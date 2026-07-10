<?php

namespace Paolorox\Restapro\Services;

use InvalidArgumentException;
use Paolorox\Restapro\Models\Unit;

class UnitConversionService
{
    protected array $unitCache = [];

    /**
     * Converte una quantità da un'unità ad un'altra dello stesso tipo.
     *
     * Logica: from → base (× conversion_factor) → to (÷ conversion_factor)
     */
    public function convert(float $quantity, int $fromUnitId, int $toUnitId): float
    {
        if ($fromUnitId === $toUnitId) {
            return $quantity;
        }

        $fromUnit = $this->getUnit($fromUnitId);
        $toUnit = $this->getUnit($toUnitId);

        if (!$fromUnit || !$toUnit) {
            throw new InvalidArgumentException(
                "Unit not found: from={$fromUnitId}, to={$toUnitId}"
            );
        }

        if ($fromUnit->type !== $toUnit->type) {
            throw new InvalidArgumentException(
                "Cannot convert between different unit types: {$fromUnit->type} → {$toUnit->type}"
            );
        }

        $baseQuantity = $quantity * $fromUnit->conversion_factor;
        $result = $toUnit->conversion_factor > 0
            ? $baseQuantity / $toUnit->conversion_factor
            : 0;

        return round($result, 6);
    }

    public function areCompatible(int $unitId1, int $unitId2): bool
    {
        if ($unitId1 === $unitId2) {
            return true;
        }

        $unit1 = $this->getUnit($unitId1);
        $unit2 = $this->getUnit($unitId2);

        if (!$unit1 || !$unit2) {
            return false;
        }

        return $unit1->type === $unit2->type;
    }

    protected function getUnit(int $id): ?Unit
    {
        if (!isset($this->unitCache[$id])) {
            $this->unitCache[$id] = Unit::find($id);
        }

        return $this->unitCache[$id];
    }

    public function clearCache(): void
    {
        $this->unitCache = [];
    }
}
