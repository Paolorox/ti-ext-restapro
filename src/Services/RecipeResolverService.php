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

                    $this->inventoryEngine->recordSale(
                        $ingredient,
                        $requiredQty,
                        (string) $order->order_id,
                        "Order #{$order->order_id} - {$recipe->name} x{$quantity}",
                    );

                    $totalDeductions[$ingredientId] = ($totalDeductions[$ingredientId] ?? 0) + $requiredQty;
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

            $result[$ingredientId] = [
                'name' => $ingredient->name,
                'unit' => $ingredient->unit->abbreviation ?? '',
                'required' => round($required, 3),
                'available' => $ingredient->stock,
                'sufficient' => $ingredient->stock >= $required,
            ];
        }

        return $result;
    }
}
