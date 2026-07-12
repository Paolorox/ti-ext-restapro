<?php

namespace Paolorox\Restapro\Services;

use Illuminate\Support\Facades\Log;
use Paolorox\Restapro\Models\Ingredient;
use Paolorox\Restapro\Models\Recipe;
use Paolorox\Restapro\Models\StockMovement;

class RecipeResolverService
{
    protected InventoryEngine $inventoryEngine;

    public function __construct(InventoryEngine $inventoryEngine)
    {
        $this->inventoryEngine = $inventoryEngine;
    }

    /**
     * Processa un ordine TastyIgniter e scarica le giacenze.
     */
    public function deductStockForOrder($order): array
    {
        $totalDeductions = [];

        try {
            // Idempotenza: se questo ordine ha già generato movimenti di
            // vendita, non scaricare di nuovo (l'evento pagamento può
            // scattare più volte o l'ordine può essere rielaborato).
            $alreadyDeducted = StockMovement::query()
                ->where('reference_type', 'order')
                ->where('reference_id', (string) $order->order_id)
                ->exists();

            if ($alreadyDeducted) {
                Log::info("[RestaPro] Order #{$order->order_id} already deducted, skipping");

                return [];
            }

            $orderMenus = $order->getOrderMenus();

            if (!$orderMenus || $orderMenus->isEmpty()) {
                Log::info("[RestaPro] No menu items found in order #{$order->order_id}");
                return [];
            }

            foreach ($orderMenus as $orderMenu) {
                $menuId = $orderMenu->menu_id ?? null;
                $quantity = $orderMenu->quantity ?? 1;

                if (!$menuId) {
                    continue;
                }

                $recipe = Recipe::where('menu_id', $menuId)
                    ->where('is_active', true)
                    ->first();

                if (!$recipe) {
                    Log::debug("[RestaPro] No recipe found for menu_id={$menuId}");
                    continue;
                }

                $ingredients = $recipe->explodeIngredients($quantity);

                foreach ($ingredients as $ingredientId => $requiredQty) {
                    $ingredient = Ingredient::find($ingredientId);
                    if (!$ingredient) {
                        continue;
                    }

                    // Adjust required quantity based on yield
                    $yieldPercentage = $ingredient->yield_percentage ?? 100;
                    $yieldRatio = $yieldPercentage > 0 ? ($yieldPercentage / 100) : 1;
                    $quantityToDeduct = $requiredQty / $yieldRatio;

                    $this->inventoryEngine->recordSale(
                        $ingredient,
                        $quantityToDeduct,
                        (string) $order->order_id,
                        "Order #{$order->order_id} - {$recipe->name} x{$quantity}",
                    );

                    $totalDeductions[$ingredientId] = ($totalDeductions[$ingredientId] ?? 0) + $quantityToDeduct;
                }
            }

            Log::info("[RestaPro] Order #{$order->order_id}: deducted " . count($totalDeductions) . ' ingredients');
        } catch (\Throwable $e) {
            Log::error("[RestaPro] Error processing order #{$order->order_id}: {$e->getMessage()}", [
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return $totalDeductions;
    }

    /**
     * Ripristina le giacenze per un ordine annullato/rimborsato.
     */
    public function restoreStockForOrder($order): array
    {
        $totalRestored = [];

        try {
            // Controlla se abbiamo già effettuato un reso per questo ordine
            $alreadyRestored = StockMovement::query()
                ->where('reference_type', 'order_return')
                ->where('reference_id', (string) $order->order_id)
                ->exists();

            if ($alreadyRestored) {
                Log::info("[RestaPro] Order #{$order->order_id} already restored, skipping");
                return [];
            }

            // Dobbiamo sapere cosa è stato scaricato.
            // Opzione A: ricalcolarlo dal menu (come deductStockForOrder)
            // Opzione B: usare i movimenti di magazzino creati originariamente.
            // Opzione B è molto più sicura nel caso in cui la ricetta sia cambiata nel tempo.
            
            $deductions = StockMovement::query()
                ->where('reference_type', 'order')
                ->where('reference_id', (string) $order->order_id)
                ->where('type', StockMovement::TYPE_SALE)
                ->get();

            if ($deductions->isEmpty()) {
                Log::info("[RestaPro] No previous deductions found for order #{$order->order_id}, nothing to restore.");
                return [];
            }

            foreach ($deductions as $movement) {
                $ingredient = $movement->ingredient;
                if (!$ingredient) {
                    continue;
                }

                // $movement->quantity is negative for sales, we use abs() inside recordReturn
                $quantityToRestore = abs($movement->quantity);

                $this->inventoryEngine->recordReturn(
                    $ingredient,
                    $quantityToRestore,
                    (string) $order->order_id,
                    "Order #{$order->order_id} Cancelled - Restored {$ingredient->name}",
                );

                $totalRestored[$ingredient->id] = ($totalRestored[$ingredient->id] ?? 0) + $quantityToRestore;
            }

            Log::info("[RestaPro] Order #{$order->order_id} cancelled: restored " . count($totalRestored) . ' ingredients');
        } catch (\Throwable $e) {
            Log::error("[RestaPro] Error restoring stock for order #{$order->order_id}: {$e->getMessage()}", [
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return $totalRestored;
    }

    /**
     * Preview senza scaricare — utile per validazione disponibilità.
     */
    public function previewOrderDeduction($order): array
    {
        $result = [];
        $orderMenus = $order->getOrderMenus();

        if (!$orderMenus || $orderMenus->isEmpty()) {
            return [];
        }

        $totalRequired = [];

        foreach ($orderMenus as $orderMenu) {
            $menuId = $orderMenu->menu_id ?? null;
            $quantity = $orderMenu->quantity ?? 1;

            if (!$menuId) {
                continue;
            }

            $recipe = Recipe::where('menu_id', $menuId)
                ->where('is_active', true)
                ->first();

            if (!$recipe) {
                continue;
            }

            $ingredients = $recipe->explodeIngredients($quantity);

            foreach ($ingredients as $ingredientId => $requiredQty) {
                $totalRequired[$ingredientId] = ($totalRequired[$ingredientId] ?? 0) + $requiredQty;
            }
        }

        foreach ($totalRequired as $ingredientId => $required) {
            $ingredient = Ingredient::with('unit')->find($ingredientId);
            if (!$ingredient) {
                continue;
            }

            $yieldPercentage = $ingredient->yield_percentage ?? 100;
            $yieldRatio = $yieldPercentage > 0 ? ($yieldPercentage / 100) : 1;
            $quantityRequired = $required / $yieldRatio;

            $result[$ingredientId] = [
                'name' => $ingredient->name,
                'unit' => $ingredient->unit->abbreviation ?? '',
                'required' => round($quantityRequired, 3),
                'available' => $ingredient->stock,
                'sufficient' => $ingredient->stock >= $quantityRequired,
            ];
        }

        return $result;
    }
}
