<?php

namespace Paolorox\Restapro\Models\Concerns;

use Paolorox\Restapro\Services\UnitConversionService;

trait CalculatesFoodCost
{
    /**
     * Ricalcola il costo totale della ricetta sommando il costo di ogni ingrediente.
     * Gestisce i semilavorati (sub-recipes) ricorsivamente.
     */
    public function recalculateCost(array $visited = []): float
    {
        if (in_array($this->id, $visited)) {
            return 0;
        }

        $visited[] = $this->id;
        $totalCost = 0;

        foreach ($this->recipeIngredients as $ri) {
            if ($ri->ingredient_id) {
                $ingredient = $ri->ingredient;
                if (!$ingredient) {
                    continue;
                }

                $quantity = $ri->quantity;
                if ($ri->unit_id !== $ingredient->unit_id) {
                    $quantity = app(UnitConversionService::class)
                        ->convert($ri->quantity, $ri->unit_id, $ingredient->unit_id);
                }

                $totalCost += $quantity * $ingredient->average_cost;
            } elseif ($ri->sub_recipe_id) {
                $subRecipe = $ri->subRecipe;
                if (!$subRecipe) {
                    continue;
                }

                $subCost = $subRecipe->recalculateCost($visited);
                $costPerUnit = $subRecipe->yield_amount > 0
                    ? $subCost / $subRecipe->yield_amount
                    : $subCost;

                $quantity = $ri->quantity;
                if ($ri->unit_id && $subRecipe->yield_unit_id && $ri->unit_id !== $subRecipe->yield_unit_id) {
                    $quantity = app(UnitConversionService::class)
                        ->convert($ri->quantity, $ri->unit_id, $subRecipe->yield_unit_id);
                }

                $totalCost += $quantity * $costPerUnit;
            }
        }

        return round($totalCost, 4);
    }

    /**
     * Ricalcola e salva il costo nel database.
     */
    public function updateCalculatedCost(): void
    {
        $this->calculated_cost = $this->recalculateCost();
        $this->saveQuietly();
    }

    /**
     * Esplode tutti gli ingredienti base della ricetta (inclusi quelli dei semilavorati).
     *
     * @param float $multiplier Moltiplicatore per la quantità (es. n. porzioni)
     * @param array $visited IDs già visitati per evitare loop infiniti
     * @return array<int, float> [ingredient_id => total_quantity_base_unit]
     */
    public function explodeIngredients(float $multiplier = 1.0, array $visited = []): array
    {
        if (in_array($this->id, $visited)) {
            return [];
        }

        $visited[] = $this->id;
        $ingredients = [];

        foreach ($this->recipeIngredients as $ri) {
            if ($ri->ingredient_id) {
                $ingredient = $ri->ingredient;
                if (!$ingredient) {
                    continue;
                }

                $quantity = $ri->quantity * $multiplier;
                if ($ri->unit_id !== $ingredient->unit_id) {
                    $quantity = app(UnitConversionService::class)
                        ->convert($quantity, $ri->unit_id, $ingredient->unit_id);
                }

                $ingredientId = $ri->ingredient_id;
                $ingredients[$ingredientId] = ($ingredients[$ingredientId] ?? 0) + $quantity;
            } elseif ($ri->sub_recipe_id) {
                $subRecipe = $ri->subRecipe;
                if (!$subRecipe) {
                    continue;
                }

                $quantity = $ri->quantity * $multiplier;
                if ($ri->unit_id && $subRecipe->yield_unit_id && $ri->unit_id !== $subRecipe->yield_unit_id) {
                    $quantity = app(UnitConversionService::class)
                        ->convert($quantity, $ri->unit_id, $subRecipe->yield_unit_id);
                }

                $subMultiplier = $subRecipe->yield_amount > 0
                    ? $quantity / $subRecipe->yield_amount
                    : $quantity;

                $subIngredients = $subRecipe->explodeIngredients($subMultiplier, $visited);

                foreach ($subIngredients as $id => $qty) {
                    $ingredients[$id] = ($ingredients[$id] ?? 0) + $qty;
                }
            }
        }

        return $ingredients;
    }
}
