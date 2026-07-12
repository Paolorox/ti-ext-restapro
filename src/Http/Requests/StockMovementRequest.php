<?php

namespace Paolorox\Restapro\Http\Requests;

use Igniter\System\Classes\FormRequest;

class StockMovementRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'ingredient_id' => 'lang:paolorox.restapro::default.stock_movement_ingredient',
            'type' => 'lang:paolorox.restapro::default.stock_movement_type',
            'quantity' => 'lang:paolorox.restapro::default.stock_movement_quantity',
            'unit_cost' => 'lang:paolorox.restapro::default.stock_movement_unit_cost',
        ];
    }

    public function rules(): array
    {
        return [
            'ingredient_id' => ['required', 'integer'],
            'type' => ['required', 'string', 'in:purchase,sale,waste,adjustment'],
            'quantity' => ['required', 'numeric'],
            'unit_cost' => ['nullable', 'numeric'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
