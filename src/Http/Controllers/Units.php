<?php

namespace Paolorox\Restapro\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;

class Units extends AdminController
{
    public array $implement = [
        \Igniter\Admin\Http\Actions\ListController::class,
        \Igniter\Admin\Http\Actions\FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => \Paolorox\Restapro\Models\Unit::class,
            'title' => 'paolorox.restapro::default.unit_title',
            'emptyMessage' => 'paolorox.restapro::default.text_empty',
            'defaultSort' => ['type', 'ASC'],
            'configFile' => 'unit',
            'recordUrl' => 'paolorox/restapro/units/edit/{id}',
        ],
    ];

    public array $formConfig = [
        'name' => 'paolorox.restapro::default.unit_title',
        'model' => \Paolorox\Restapro\Models\Unit::class,
        'request' => \Paolorox\Restapro\Http\Requests\UnitRequest::class,
        'create' => [
            'title' => 'lang:admin::lang.text_new',
            'redirect' => 'paolorox/restapro/units/edit/{id}',
            'redirectClose' => 'paolorox/restapro/units',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.text_edit',
            'redirect' => 'paolorox/restapro/units/edit/{id}',
            'redirectClose' => 'paolorox/restapro/units',
        ],
        'configFile' => 'unit',
    ];

    public null|string|array $requiredPermissions = ['Paolorox.Restapro.ManageUnits'];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('units', 'production');
    }
}
