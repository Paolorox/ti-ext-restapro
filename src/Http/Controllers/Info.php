<?php

namespace Paolorox\Restapro\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Illuminate\Support\Facades\Schema;
use Paolorox\Restapro\Models\Category;
use Paolorox\Restapro\Models\Ingredient;
use Paolorox\Restapro\Models\PurchaseOrder;
use Paolorox\Restapro\Models\Recipe;
use Paolorox\Restapro\Models\StockMovement;
use Paolorox\Restapro\Models\Supplier;
use Paolorox\Restapro\Models\Unit;

class Info extends AdminController
{
    public null|string|array $requiredPermissions = ['Paolorox.Restapro.ViewInfo'];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('settings', 'system');
    }

    public function index()
    {
        $this->pageTitle = lang('paolorox.restapro::default.info_title');

        // System counters
        $this->vars['totalIngredients'] = Ingredient::count();
        $this->vars['totalRecipes'] = Recipe::count();
        $this->vars['totalSuppliers'] = Supplier::count();
        $this->vars['totalCategories'] = Category::count();
        $this->vars['totalUnits'] = Unit::count();
        $this->vars['totalPurchaseOrders'] = PurchaseOrder::count();
        $this->vars['totalStockMovements'] = StockMovement::count();

        // Database health check
        $requiredTables = [
            'fc_units',
            'fc_categories',
            'fc_suppliers',
            'fc_ingredients',
            'fc_recipes',
            'fc_recipe_ingredients',
            'fc_stock_movements',
            'fc_purchase_orders',
            'fc_purchase_order_items',
        ];

        $missingTables = [];
        foreach ($requiredTables as $table) {
            if (!Schema::hasTable($table)) {
                $missingTables[] = $table;
            }
        }

        $this->vars['requiredTables'] = $requiredTables;
        $this->vars['missingTables'] = $missingTables;
        $this->vars['dbOk'] = empty($missingTables);

        // Extension info
        $this->vars['extensionVersion'] = '1.1.1';
        $this->vars['extensionAuthor'] = 'Paolorox';
        $this->vars['extensionLicense'] = 'GPL-3.0-or-later';
        $this->vars['extensionHomepage'] = 'https://github.com/Paolorox/ti-ext-restapro';

        return $this->makeView('paolorox.restapro::info.index');
    }
}
