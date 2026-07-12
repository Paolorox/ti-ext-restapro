<?php

namespace Paolorox\Restapro\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;

class Suppliers extends AdminController
{
    public array $implement = [
        \Igniter\Admin\Http\Actions\ListController::class,
        \Igniter\Admin\Http\Actions\FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => \Paolorox\Restapro\Models\Supplier::class,
            'title' => 'paolorox.restapro::default.supplier_title',
            'emptyMessage' => 'paolorox.restapro::default.text_empty',
            'defaultSort' => ['name', 'ASC'],
            'configFile' => 'supplier',
            'recordUrl' => 'paolorox/restapro/suppliers/edit/{id}',
        ],
    ];

    public array $formConfig = [
        'name' => 'paolorox.restapro::default.supplier_title',
        'model' => \Paolorox\Restapro\Models\Supplier::class,
        'request' => \Paolorox\Restapro\Http\Requests\SupplierRequest::class,
        'create' => [
            'title' => 'lang:admin::lang.text_new',
            'redirect' => 'paolorox/restapro/suppliers/edit/{id}',
            'redirectClose' => 'paolorox/restapro/suppliers',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.text_edit',
            'redirect' => 'paolorox/restapro/suppliers/edit/{id}',
            'redirectClose' => 'paolorox/restapro/suppliers',
        ],
        'configFile' => 'supplier',
    ];

    public null|string|array $requiredPermissions = ['Paolorox.Restapro.ManageSuppliers'];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('paolorox.restapro', 'restapro', 'suppliers');
    }
}
