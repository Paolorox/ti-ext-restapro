<?php

namespace Paolorox\Restapro\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Paolorox\Restapro\Models\Ingredient;
use Paolorox\Restapro\Models\Recipe;
use Paolorox\Restapro\Models\StockMovement;
use Paolorox\Restapro\Services\InventoryEngine;

class Dashboard extends AdminController
{
    public null|string|array $requiredPermissions = ['Paolorox.Restapro.Dashboard'];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('dashboard', 'production');
    }

    public function index()
    {
        $this->pageTitle = lang('paolorox.restapro::default.dashboard_title');

        $inventoryEngine = app(InventoryEngine::class);

        $this->vars['totalIngredients'] = Ingredient::isActive()->count();
        $this->vars['totalRecipes'] = Recipe::isActive()->count();
        $this->vars['totalInventoryValue'] = $inventoryEngine->getTotalInventoryValue();
        $this->vars['lowStockIngredients'] = $inventoryEngine->getLowStockIngredients();
        $this->vars['lowStockCount'] = $this->vars['lowStockIngredients']->count();

        $this->vars['overTargetRecipes'] = Recipe::isActive()
            ->menuItems()
            ->with('menu')
            ->get()
            ->filter(function ($recipe) {
                $actual = $recipe->actual_food_cost_percent;

                return $actual !== null && $actual > $recipe->target_food_cost;
            });

        $this->vars['recentMovements'] = StockMovement::with('ingredient')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return $this->makeView('index');
    }
}
