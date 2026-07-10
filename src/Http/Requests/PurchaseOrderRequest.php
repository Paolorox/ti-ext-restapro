<?php

namespace Paolorox\Restapro\Http\Requests;

use Igniter\System\Classes\FormRequest;

class PurchaseOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'supplier_id' => 'required|integer|exists:fc_suppliers,id',
            'reference' => 'nullable|string|max:255',
            'status' => 'required|string|in:draft,ordered,received,cancelled',
            'notes' => 'nullable|string',
            'order_date' => 'nullable|date',
            'received_date' => 'nullable|date',
        ];
    }
}
