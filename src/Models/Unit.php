<?php

namespace Paolorox\Restapro\Models;

use Igniter\Flame\Database\Model;

class Unit extends Model
{
    protected $table = 'fc_units';

    protected $fillable = [
        'name',
        'abbreviation',
        'type',
        'conversion_factor',
        'base_unit_id',
        'is_active',
    ];

    protected $casts = [
        'conversion_factor' => 'float',
        'base_unit_id' => 'integer',
        'is_active' => 'boolean',
    ];

    public $relation = [
        'belongsTo' => [
            'baseUnit' => [Unit::class, 'foreignKey' => 'base_unit_id'],
        ],
        'hasMany' => [
            'derivedUnits' => [Unit::class, 'foreignKey' => 'base_unit_id'],
            'ingredients' => [Ingredient::class, 'foreignKey' => 'unit_id'],
        ],
    ];

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function convertToBase(float $quantity): float
    {
        return $quantity * $this->conversion_factor;
    }

    public function convertFromBase(float $quantity): float
    {
        if ($this->conversion_factor == 0) {
            return 0;
        }

        return $quantity / $this->conversion_factor;
    }

    public static function getDropdownOptions(): array
    {
        return static::isActive()
            ->orderBy('type')
            ->orderBy('name')
            ->get()
            ->mapWithKeys(fn ($unit) => [$unit->id => "{$unit->name} ({$unit->abbreviation})"])
            ->toArray();
    }
}
