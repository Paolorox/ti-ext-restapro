<?php

namespace Paolorox\Restapro\Models;

use Igniter\Flame\Database\Model;
use Paolorox\Restapro\Models\Concerns\CalculatesFoodCost;

class Recipe extends Model
{
    use CalculatesFoodCost;

    protected $table = 'fc_recipes';

    protected $fillable = [
        'menu_id',
        'name',
        'type',
        'yield_amount',
        'yield_unit_id',
        'target_food_cost',
        'calculated_cost',
        'instructions',
        'is_active',
    ];

    protected $casts = [
        'menu_id' => 'integer',
        'yield_amount' => 'float',
        'yield_unit_id' => 'integer',
        'target_food_cost' => 'float',
        'calculated_cost' => 'float',
        'is_active' => 'boolean',
    ];

    public $relation = [
        'belongsTo' => [
            'menu' => [\Igniter\Cart\Models\Menu::class, 'foreignKey' => 'menu_id', 'otherKey' => 'menu_id'],
            'yieldUnit' => [Unit::class, 'foreignKey' => 'yield_unit_id'],
        ],
        'hasMany' => [
            'recipeIngredients' => [RecipeIngredient::class, 'foreignKey' => 'recipe_id'],
            'parentRecipes' => [RecipeIngredient::class, 'foreignKey' => 'sub_recipe_id'],
        ],
    ];

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMenuItems($query)
    {
        return $query->where('type', 'menu_item');
    }

    public function scopeSubRecipes($query)
    {
        return $query->where('type', 'sub_recipe');
    }

    public function scopeForMenu($query, int $menuId)
    {
        return $query->where('menu_id', $menuId);
    }

    public function getCostPerPortionAttribute(): float
    {
        if ($this->yield_amount <= 0) {
            return $this->calculated_cost;
        }

        return $this->calculated_cost / $this->yield_amount;
    }

    public function getActualFoodCostPercentAttribute(): ?float
    {
        if (!$this->menu || $this->menu->menu_price <= 0) {
            return null;
        }

        return ($this->cost_per_portion / $this->menu->menu_price) * 100;
    }

    public function getMarginAttribute(): ?float
    {
        if (!$this->menu) {
            return null;
        }

        return $this->menu->menu_price - $this->cost_per_portion;
    }

    public function getTypeOptions(): array
    {
        return [
            'menu_item' => lang('paolorox.restapro::default.recipe_type_menu_item'),
            'sub_recipe' => lang('paolorox.restapro::default.recipe_type_sub_recipe'),
        ];
    }


    public static function getSubRecipeOptions(): array
    {
        return static::subRecipes()
            ->isActive()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function afterSave()
    {
        $this->saveIngredients();
    }

    protected function saveIngredients()
    {
        $ingredientsData = post('Recipe.recipeIngredients') ?: post('recipeIngredients');

        if (!is_array($ingredientsData)) {
            return;
        }

        $this->recipeIngredients()->delete();

        foreach ($ingredientsData as $data) {
            $ingredientId = !empty($data['ingredient_id']) ? (int)$data['ingredient_id'] : null;
            $subRecipeId = !empty($data['sub_recipe_id']) ? (int)$data['sub_recipe_id'] : null;
            $quantity = !empty($data['quantity']) ? (float)$data['quantity'] : 0.0;
            $unitId = !empty($data['unit_id']) ? (int)$data['unit_id'] : null;

            if (($ingredientId || $subRecipeId) && $quantity > 0 && $unitId) {
                $this->recipeIngredients()->create([
                    'ingredient_id' => $ingredientId,
                    'sub_recipe_id' => $subRecipeId,
                    'quantity' => $quantity,
                    'unit_id' => $unitId,
                ]);
            }
        }

        // Ricarica la relazione (bust della cache) prima di ricalcolare il costo
        $this->load('recipeIngredients');
        $this->updateCalculatedCost();
    }
}
