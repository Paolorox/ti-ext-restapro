<?php

namespace Paolorox\Restapro\Models;

use Igniter\Flame\Database\Model;

class RecipeIngredient extends Model
{
    protected $table = 'fc_recipe_ingredients';

    protected $fillable = [
        'recipe_id',
        'ingredient_id',
        'sub_recipe_id',
        'quantity',
        'unit_id',
    ];

    protected $casts = [
        'recipe_id' => 'integer',
        'ingredient_id' => 'integer',
        'sub_recipe_id' => 'integer',
        'quantity' => 'float',
        'unit_id' => 'integer',
    ];

    public $relation = [
        'belongsTo' => [
            'recipe' => [Recipe::class, 'foreignKey' => 'recipe_id'],
            'ingredient' => [Ingredient::class, 'foreignKey' => 'ingredient_id'],
            'subRecipe' => [Recipe::class, 'foreignKey' => 'sub_recipe_id'],
            'unit' => [Unit::class, 'foreignKey' => 'unit_id'],
        ],
    ];

    public function getLineCostAttribute(): float
    {
        if ($this->ingredient_id && $this->ingredient) {
            return $this->quantity * $this->ingredient->average_cost;
        }

        if ($this->sub_recipe_id && $this->subRecipe) {
            $costPerUnit = $this->subRecipe->yield_amount > 0
                ? $this->subRecipe->calculated_cost / $this->subRecipe->yield_amount
                : $this->subRecipe->calculated_cost;

            return $this->quantity * $costPerUnit;
        }

        return 0;
    }

    public function getDisplayNameAttribute(): string
    {
        if ($this->ingredient) {
            return $this->ingredient->name;
        }

        if ($this->subRecipe) {
            return '[SL] ' . $this->subRecipe->name;
        }

        return '—';
    }
}
