<?php

namespace Paolorox\Restapro\Models;

use Igniter\Flame\Database\Model;

class Category extends Model
{
    protected $table = 'fc_categories';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $relation = [
        'hasMany' => [
            'ingredients' => [Ingredient::class, 'foreignKey' => 'category_id'],
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
