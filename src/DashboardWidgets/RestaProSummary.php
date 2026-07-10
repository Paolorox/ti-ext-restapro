<?php

namespace Paolorox\Restapro\DashboardWidgets;

use Igniter\Admin\Classes\BaseDashboardWidget;
use Paolorox\Restapro\Models\PurchaseOrder;
use Paolorox\Restapro\Services\InventoryEngine;

class RestaProSummary extends BaseDashboardWidget
{
    public string $defaultAlias = 'restaprosummary';

    public function defineProperties(): array
    {
        return [
            'title' => [
                'label' => 'Widget Title',
                'default' => 'RestaPro',
                'type' => 'text',
            ],
        ];
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('paolorox.restapro::dashboardwidgets/restaprosummary/restaprosummary');
    }

    protected function prepareVars()
    {
        $inventoryEngine = app(InventoryEngine::class);

        $this->vars['lowStockCount'] = $inventoryEngine->getLowStockIngredients()->count();
        $this->vars['pendingOrdersCount'] = PurchaseOrder::whereIn('status', ['pending', 'processing'])->count();
    }
}
