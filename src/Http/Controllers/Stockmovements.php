<?php

namespace Paolorox\Restapro\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;

class Stockmovements extends AdminController
{
    public array $implement = [
        \Igniter\Admin\Http\Actions\ListController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => \Paolorox\Restapro\Models\StockMovement::class,
            'title' => 'paolorox.restapro::default.stock_movement_title',
            'emptyMessage' => 'paolorox.restapro::default.text_empty',
            'defaultSort' => ['created_at', 'DESC'],
            'configFile' => 'stockmovement',
        ],
    ];

    public null|string|array $requiredPermissions = ['Paolorox.Restapro.ViewStockMovements'];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('stockmovements', 'production');
    }
}
