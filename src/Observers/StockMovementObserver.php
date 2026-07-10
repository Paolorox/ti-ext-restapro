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
