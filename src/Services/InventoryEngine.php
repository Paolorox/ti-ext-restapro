<?php

namespace Paolorox\Restapro\Services;

use Illuminate\Support\Facades\Auth;
use Paolorox\Restapro\Models\Ingredient;
use Paolorox\Restapro\Models\StockMovement;

class InventoryEngine
{
    public function recordPurchase(
        Ingredient $ingredient,
        float $quantity,
        float $unitCost,
        ?string $referenceId = null,
        ?string $notes = null,
    ): StockMovement {
        return StockMovement::create([
            'ingredient_id' => $ingredient->id,
            'type' => StockMovement::TYPE_PURCHASE,
            'quantity' => abs($quantity),
            'unit_cost' => $unitCost,
            'reference_id' => $referenceId,
            'reference_type' => 'purchase_order',
            'notes' => $notes,
            'user_id' => Auth::id(),
        ]);
    }

    public function recordSale(
        Ingredient $ingredient,
        float $quantity,
        ?string $referenceId = null,
        ?string $notes = null,
    ): StockMovement {
        return StockMovement::create([
            'ingredient_id' => $ingredient->id,
            'type' => StockMovement::TYPE_SALE,
            'quantity' => -abs($quantity),
            'unit_cost' => $ingredient->average_cost,
            'reference_id' => $referenceId,
            'reference_type' => 'order',
            'notes' => $notes,
            'user_id' => Auth::id(),
        ]);
    }

    public function recordWaste(
        Ingredient $ingredient,
        float $quantity,
        ?string $reason = null,
    ): StockMovement {
        return StockMovement::create([
            'ingredient_id' => $ingredient->id,
            'type' => StockMovement::TYPE_WASTE,
            'quantity' => -abs($quantity),
            'unit_cost' => $ingredient->average_cost,
            'reference_id' => null,
            'reference_type' => 'manual',
            'notes' => $reason,
            'user_id' => Auth::id(),
        ]);
    }

    public function adjustStock(
        Ingredient $ingredient,
        float $quantity,
        ?string $notes = null,
    ): StockMovement {
        return StockMovement::create([
            'ingredient_id' => $ingredient->id,
            'type' => StockMovement::TYPE_ADJUSTMENT,
            'quantity' => $quantity,
            'unit_cost' => $ingredient->average_cost,
            'reference_id' => null,
            'reference_type' => 'manual',
            'notes' => $notes,
            'user_id' => Auth::id(),
        ]);
    }

    public function recordReturn(
        Ingredient $ingredient,
        float $quantity,
        ?string $referenceId = null,
        ?string $notes = null,
    ): StockMovement {
        return StockMovement::create([
            'ingredient_id' => $ingredient->id,
            'type' => StockMovement::TYPE_ADJUSTMENT,
            'quantity' => abs($quantity),
            'unit_cost' => $ingredient->average_cost,
            'reference_id' => $referenceId,
            'reference_type' => 'order_return',
            'notes' => $notes,
            'user_id' => Auth::id(),
        ]);
    }

    public function getLowStockIngredients()
    {
        return Ingredient::isActive()
            ->lowStock()
            ->with(['unit', 'category', 'supplier'])
            ->orderBy('stock', 'asc')
            ->get();
    }

    public function getTotalInventoryValue(): float
    {
        return Ingredient::isActive()
            ->get()
            ->sum(function ($ingredient) {
                return $ingredient->stock * $ingredient->average_cost;
            });
    }

    public function processPurchaseOrder(\Paolorox\Restapro\Models\PurchaseOrder $purchaseOrder): void
    {
        $conversionService = app(UnitConversionService::class);

        foreach ($purchaseOrder->items as $item) {
            $ingredient = $item->ingredient;
            if (!$ingredient) {
                continue;
            }

            $quantity = $item->quantity;
            $unitCost = $item->unit_cost;

            if ($item->unit_id !== $ingredient->unit_id) {
                $convertedQuantity = $conversionService->convert(
                    $quantity,
                    $item->unit_id,
                    $ingredient->unit_id
                );

                if ($convertedQuantity > 0) {
                    $unitCost = ($quantity * $item->unit_cost) / $convertedQuantity;
                }

                $quantity = $convertedQuantity;
            }

            $this->recordPurchase(
                $ingredient,
                $quantity,
                $unitCost,
                (string) $purchaseOrder->id,
                "PO #{$purchaseOrder->reference} - {$ingredient->name}",
            );
        }

        $purchaseOrder->recalculateTotal();
    }
}
