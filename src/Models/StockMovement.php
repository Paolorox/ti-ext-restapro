<?php

namespace Paolorox\Restapro\Models;

use Igniter\Flame\Database\Model;

class StockMovement extends Model
{
    protected $table = 'fc_stock_movements';

    protected $fillable = [
        'ingredient_id',
        'type',
        'quantity',
        'unit_cost',
        'reference_id',
        'reference_type',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'ingredient_id' => 'integer',
        'quantity' => 'float',
        'unit_cost' => 'float',
        'user_id' => 'integer',
    ];

    public const TYPE_PURCHASE = 'purchase';
    public const TYPE_SALE = 'sale';
    public const TYPE_WASTE = 'waste';
    public const TYPE_ADJUSTMENT = 'adjustment';

    public const TYPES = [
        self::TYPE_PURCHASE => 'Purchase',
        self::TYPE_SALE => 'Sale',
        self::TYPE_WASTE => 'Waste',
        self::TYPE_ADJUSTMENT => 'Adjustment',
    ];

    public $relation = [
        'belongsTo' => [
            'ingredient' => [Ingredient::class, 'foreignKey' => 'ingredient_id'],
        ],
    ];

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopePurchases($query)
    {
        return $query->where('type', self::TYPE_PURCHASE);
    }

    public function scopeSales($query)
    {
        return $query->where('type', self::TYPE_SALE);
    }

    public function getTypeNameAttribute(): string
    {
        return lang('paolorox.restapro::default.stock_movement_type_' . $this->type);
    }

    public function getTotalCostAttribute(): float
    {
        return abs($this->quantity) * $this->unit_cost;
    }

    public function getTypeOptions(): array
    {
        return [
            self::TYPE_PURCHASE => lang('paolorox.restapro::default.stock_movement_type_purchase'),
            self::TYPE_SALE => lang('paolorox.restapro::default.stock_movement_type_sale'),
            self::TYPE_WASTE => lang('paolorox.restapro::default.stock_movement_type_waste'),
            self::TYPE_ADJUSTMENT => lang('paolorox.restapro::default.stock_movement_type_adjustment'),
        ];
    }
}


