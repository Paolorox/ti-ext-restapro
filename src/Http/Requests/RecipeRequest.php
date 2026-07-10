<?php

namespace Paolorox\Restapro\Http\Requests;

use Igniter\System\Classes\FormRequest;

class RecipeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'menu_id' => 'nullable|integer|exists:menus,menu_id',
            'type' => 'required|string|in:menu_item,sub_recipe',
            'yield_amount' => 'nullable|numeric|min:0.01',
            'yield_unit_id' => 'nullable|integer|exists:fc_units,id',
            'target_food_cost' => 'nullable|numeric|min:0|max:100',
            'instructions' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ];
    }
}
