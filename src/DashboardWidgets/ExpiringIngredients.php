<?php

namespace Paolorox\Restapro\DashboardWidgets;

use Igniter\Admin\Classes\BaseDashboardWidget;
use Paolorox\Restapro\Models\Ingredient;

class ExpiringIngredients extends BaseDashboardWidget
{
    public string $defaultAlias = 'expiring-ingredients';

    public function initialize()
    {
        $this->setProperty('title', lang('paolorox.restapro::default.widget_expiring_title'));
    }

    public function defineProperties(): array
    {
        return [
            'title' => [
                'label' => 'admin::lang.dashboard.label_widget_title',
                'default' => lang('paolorox.restapro::default.widget_expiring_title'),
            ],
        ];
    }

    public function loadAssets()
    {
        // ...
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('paolorox.restapro::dashboardwidgets/expiring_ingredients');
    }

    public function prepareVars()
    {
        $this->vars['expiringSoon'] = Ingredient::isActive()
            ->expiringSoon()
            ->with(['unit'])
            ->orderBy('expiry_date', 'asc')
            ->get();
            
        $this->vars['expired'] = Ingredient::isActive()
            ->expired()
            ->with(['unit'])
            ->orderBy('expiry_date', 'asc')
            ->get();
    }
}
