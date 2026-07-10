<?php

namespace Paolorox\Restapro\Http\Requests;

use Igniter\System\Classes\FormRequest;

class IngredientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:50|unique:fc_ingredients,sku,' . $this->getRecordId(),
            'category_id' => 'nullable|integer|exists:fc_categories,id',
            'unit_id' => 'required|integer|exists:fc_units,id',
            'supplier_id' => 'nullable|integer|exists:fc_suppliers,id',
            'average_cost' => 'nullable|numeric|min:0',
            'last_cost' => 'nullable|numeric|min:0',
            'stock' => 'nullable|numeric',
            'minimum_stock' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function getRecordId(): string|int|null
    {
        return $this->route('recordId') ?? $this->route('id');
    }
}
