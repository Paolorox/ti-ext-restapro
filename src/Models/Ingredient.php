<?php

namespace Paolorox\Restapro\Models;

use Igniter\Flame\Database\Model;

class Ingredient extends Model
{
    protected $table = 'fc_ingredients';

    protected $fillable = [
        'name',
        'sku',
        'category_id',
        'unit_id',
        'supplier_id',
        'average_cost',
        'last_cost',
        'stock',
        'minimum_stock',
        'is_active',
        'expiry_date',
        'expiry_alert_days',
        'yield_percentage',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'unit_id' => 'integer',
        'supplier_id' => 'integer',
        'average_cost' => 'float',
        'last_cost' => 'float',
        'stock' => 'float',
        'minimum_stock' => 'float',
        'is_active' => 'boolean',
        'expiry_date' => 'date',
        'expiry_alert_days' => 'integer',
        'yield_percentage' => 'float',
    ];

    public $relation = [
        'belongsTo' => [
            'category' => [Category::class, 'foreignKey' => 'category_id'],
            'unit' => [Unit::class, 'foreignKey' => 'unit_id'],
            'supplier' => [Supplier::class, 'foreignKey' => 'supplier_id'],
        ],
        'hasMany' => [
            'stockMovements' => [StockMovement::class, 'foreignKey' => 'ingredient_id'],
            'recipeIngredients' => [RecipeIngredient::class, 'foreignKey' => 'ingredient_id'],
        ],
    ];

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'minimum_stock')
            ->where('minimum_stock', '>', 0);
    }

    public function scopeExpiringSoon($query)
    {
        return $query->whereNotNull('expiry_date')
            ->whereRaw('DATEDIFF(expiry_date, NOW()) <= expiry_alert_days')
            ->whereRaw('DATEDIFF(expiry_date, NOW()) >= 0');
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expiry_date')
            ->whereRaw('DATEDIFF(expiry_date, NOW()) < 0');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeBySupplier($query, $supplierId)
    {
        return $query->where('supplier_id', $supplierId);
    }

    public function getIsBelowMinimumStockAttribute(): bool
    {
        return $this->minimum_stock > 0 && $this->stock <= $this->minimum_stock;
    }

    public function getStockDisplayAttribute(): string
    {
        $unit = $this->unit ? $this->unit->abbreviation : '';

        return number_format((float)$this->stock, 3) . ' ' . $unit;
    }

    public static function getDropdownOptions(): array
    {
        return static::isActive()
            ->orderBy('name')
            ->get()
            ->mapWithKeys(fn ($ingredient) => [$ingredient->id => $ingredient->name])
            ->toArray();
    }
}
