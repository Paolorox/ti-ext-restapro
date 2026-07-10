<?php

namespace Paolorox\Restapro\Http\Requests;

use Igniter\System\Classes\FormRequest;

class UnitRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:10',
            'type' => 'required|string|in:weight,volume,piece',
            'conversion_factor' => 'required|numeric|min:0.000001',
            'base_unit_id' => 'nullable|integer|exists:fc_units,id',
            'is_active' => 'nullable|boolean',
        ];
    }
}
