<?php

namespace Paolorox\Restapro\Models;

use Igniter\Flame\Database\Model;

class Supplier extends Model
{
    protected $table = 'fc_suppliers';

    protected $fillable = [
        'name',
        'contact_name',
        'email',
        'phone',
        'address',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $relation = [
        'hasMany' => [
            'ingredients' => [Ingredient::class, 'foreignKey' => 'supplier_id'],
            'purchaseOrders' => [PurchaseOrder::class, 'foreignKey' => 'supplier_id'],
        ],
    ];

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function getDropdownOptions(): array
    {
        return static::isActive()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }
}
