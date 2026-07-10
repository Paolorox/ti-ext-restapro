<?php

namespace Paolorox\Restapro\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;

class Recipes extends AdminController
{
    public array $implement = [
        \Igniter\Admin\Http\Actions\ListController::class,
        \Igniter\Admin\Http\Actions\FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => \Paolorox\Restapro\Models\Recipe::class,
            'title' => 'paolorox.restapro::default.recipe_title',
            'emptyMessage' => 'paolorox.restapro::default.text_empty',
            'defaultSort' => ['name', 'ASC'],
            'configFile' => 'recipe',
            'recordUrl' => 'paolorox/restapro/recipes/edit/{id}',
        ],
    ];

    public array $formConfig = [
        'name' => 'paolorox.restapro::default.recipe_title',
        'model' => \Paolorox\Restapro\Models\Recipe::class,
        'request' => \Paolorox\Restapro\Http\Requests\RecipeRequest::class,
        'create' => [
            'title' => 'lang:admin::lang.text_new',
            'redirect' => 'paolorox/restapro/recipes/edit/{id}',
            'redirectClose' => 'paolorox/restapro/recipes',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.text_edit',
            'redirect' => 'paolorox/restapro/recipes/edit/{id}',
            'redirectClose' => 'paolorox/restapro/recipes',
        ],
        'configFile' => 'recipe',
    ];

    public null|string|array $requiredPermissions = ['Paolorox.Restapro.ManageRecipes'];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('recipes', 'production');
    }
}
