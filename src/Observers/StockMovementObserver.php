<?php

namespace Paolorox\Restapro\Observers;

use Paolorox\Restapro\Models\Ingredient;
use Paolorox\Restapro\Models\Recipe;
use Paolorox\Restapro\Models\StockMovement;

class StockMovementObserver
{
    public function created(StockMovement $movement): void
    {
        $ingredient = $movement->ingredient;

        if (!$ingredient) {
            return;
        }

        $this->updateStock($ingredient, $movement);

        if ($movement->type === StockMovement::TYPE_PURCHASE) {
            $this->updateCosts($ingredient, $movement);
        }

        $this->propagateRecipeCosts($ingredient);
    }

    /**
     * Aggiorna la giacenza dell'ingrediente.
     */
    protected function updateStock(Ingredient $ingredient, StockMovement $movement): void
    {
        $ingredient->stock = $ingredient->stock + $movement->quantity;
        $ingredient->saveQuietly();
        
        $this->checkLowStockThreshold($ingredient);
    }

    protected function checkLowStockThreshold(Ingredient $ingredient): void
    {
        if ($ingredient->low_stock_threshold > 0 && $ingredient->stock <= $ingredient->low_stock_threshold) {
            if ($ingredient->supplier_id) {
                // Check if an active draft PO exists for this supplier
                $existingPo = \Paolorox\Restapro\Models\PurchaseOrder::where('supplier_id', $ingredient->supplier_id)
                    ->where('status', 'draft')
                    ->first();

                if (!$existingPo) {
                    $existingPo = \Paolorox\Restapro\Models\PurchaseOrder::create([
                        'supplier_id' => $ingredient->supplier_id,
                        'status' => 'draft',
                        'order_date' => now(),
                        'reference' => 'AUTO-' . strtoupper(uniqid()),
                    ]);
                }

                // Check if this ingredient is already in the PO
                $existingItem = \Paolorox\Restapro\Models\PurchaseOrderItem::where('purchase_order_id', $existingPo->id)
                    ->where('ingredient_id', $ingredient->id)
                    ->first();

                if (!$existingItem) {
                    $qtyNeeded = $ingredient->low_stock_threshold - $ingredient->stock + ($ingredient->low_stock_threshold * 0.5); // Add 50% buffer
                    if ($qtyNeeded < 1) $qtyNeeded = 1;

                    \Paolorox\Restapro\Models\PurchaseOrderItem::create([
                        'purchase_order_id' => $existingPo->id,
                        'ingredient_id' => $ingredient->id,
                        'unit_id' => $ingredient->unit_id,
                        'quantity' => ceil($qtyNeeded),
                        'unit_cost' => $ingredient->last_cost > 0 ? $ingredient->last_cost : $ingredient->average_cost,
                    ]);
                    
                    // Update PO total
                    $existingPo->recalculateTotal();
                }
            }
        }
    }

    /**
     * Ricalcola il Costo Medio Ponderato (CMP) per un acquisto.
     *
     * Formula CMP:
     * nuovo_cmp = (giacenza_precedente × cmp_attuale + quantità_acquisto × costo_acquisto)
     *             / (giacenza_precedente + quantità_acquisto)
     */
    protected function updateCosts(Ingredient $ingredient, StockMovement $movement): void
    {
        $ingredient->last_cost = $movement->unit_cost;

        $previousStock = $ingredient->stock - $movement->quantity;
        $newQuantity = $movement->quantity;
        $newCost = $movement->unit_cost;

        if ($previousStock + $newQuantity > 0) {
            $previousValue = $previousStock * $ingredient->average_cost;
            $newValue = $newQuantity * $newCost;
            $ingredient->average_cost = round(
                ($previousValue + $newValue) / ($previousStock + $newQuantity),
                4
            );
        } else {
            $ingredient->average_cost = $newCost;
        }

        $ingredient->saveQuietly();
    }

    /**
     * Ricalcola il calculated_cost di tutte le ricette che usano questo ingrediente.
     */
    protected function propagateRecipeCosts(Ingredient $ingredient): void
    {
        $recipeIds = $ingredient->recipeIngredients()
            ->pluck('recipe_id')
            ->unique();

        foreach ($recipeIds as $recipeId) {
            $recipe = Recipe::find($recipeId);
            if ($recipe) {
                $recipe->updateCalculatedCost();

                if ($recipe->type === 'sub_recipe') {
                    $this->propagateSubRecipeCosts($recipe);
                }
            }
        }
    }

    /**
     * Propaga il ricalcolo alle ricette che usano un semilavorato.
     */
    protected function propagateSubRecipeCosts(Recipe $subRecipe): void
    {
        $parentRecipeIds = $subRecipe->parentRecipes()
            ->pluck('recipe_id')
            ->unique();

        foreach ($parentRecipeIds as $recipeId) {
            $parentRecipe = Recipe::find($recipeId);
            if ($parentRecipe) {
                $parentRecipe->updateCalculatedCost();

                if ($parentRecipe->type === 'sub_recipe') {
                    $this->propagateSubRecipeCosts($parentRecipe);
                }
            }
        }
    }
}
