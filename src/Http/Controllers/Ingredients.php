<?php

namespace Paolorox\Restapro\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;

class Ingredients extends AdminController
{
    public array $implement = [
        \Igniter\Admin\Http\Actions\ListController::class,
        \Igniter\Admin\Http\Actions\FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => \Paolorox\Restapro\Models\Ingredient::class,
            'title' => 'paolorox.restapro::default.ingredient_title',
            'emptyMessage' => 'paolorox.restapro::default.text_empty',
            'defaultSort' => ['name', 'ASC'],
            'configFile' => 'ingredient',
            'recordUrl' => 'paolorox/restapro/ingredients/edit/{id}',
        ],
    ];

    public array $formConfig = [
        'name' => 'paolorox.restapro::default.ingredient_title',
        'model' => \Paolorox\Restapro\Models\Ingredient::class,
        'request' => \Paolorox\Restapro\Http\Requests\IngredientRequest::class,
        'create' => [
            'title' => 'lang:admin::lang.text_new',
            'redirect' => 'paolorox/restapro/ingredients/edit/{id}',
            'redirectClose' => 'paolorox/restapro/ingredients',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.text_edit',
            'redirect' => 'paolorox/restapro/ingredients/edit/{id}',
            'redirectClose' => 'paolorox/restapro/ingredients',
        ],
        'configFile' => 'ingredient',
    ];

    public null|string|array $requiredPermissions = ['Paolorox.Restapro.ManageIngredients'];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('ingredients', 'production');
    }
}
