<?php

namespace Paolorox\Restapro\Models;

use Igniter\Flame\Database\Model;

class PurchaseOrderItem extends Model
{
    protected $table = 'fc_purchase_order_items';

    protected $fillable = [
        'purchase_order_id',
        'ingredient_id',
        'quantity',
        'unit_cost',
        'unit_id',
        'expiry_date',
    ];

    protected $casts = [
        'purchase_order_id' => 'integer',
        'ingredient_id' => 'integer',
        'quantity' => 'float',
        'unit_cost' => 'float',
        'unit_id' => 'integer',
        'expiry_date' => 'date',
    ];

    public $relation = [
        'belongsTo' => [
            'purchaseOrder' => [PurchaseOrder::class, 'foreignKey' => 'purchase_order_id'],
            'ingredient' => [Ingredient::class, 'foreignKey' => 'ingredient_id'],
            'unit' => [Unit::class, 'foreignKey' => 'unit_id'],
        ],
    ];

    public function getLineTotalAttribute(): float
    {
        return $this->quantity * $this->unit_cost;
    }
}
