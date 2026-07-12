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

    public function exportCsv()
    {
        $ingredients = \Paolorox\Restapro\Models\Ingredient::with(['category', 'unit'])->orderBy('name')->get();
        $csv = "ID,Name,SKU,Category,Stock Quantity,Unit,Low Stock Threshold,Expiry Date,Is Active\n";
        
        foreach ($ingredients as $i) {
            $category = $i->category ? str_replace('"', '""', $i->category->name) : '';
            $unit = $i->unit ? str_replace('"', '""', $i->unit->abbreviation) : '';
            $name = str_replace('"', '""', $i->name);
            $sku = str_replace('"', '""', $i->sku);
            $active = $i->is_active ? 'Yes' : 'No';
            
            $csv .= "{$i->id},\"{$name}\",\"{$sku}\",\"{$category}\",{$i->stock},\"{$unit}\",{$i->minimum_stock},{$i->expiry_date},{$active}\n";
        }
        
        return \Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="ingredients_'.date('Y-m-d').'.csv"',
        ]);
    }

    public function onLoadAddMovementForm()
    {
        $ingredients = \Paolorox\Restapro\Models\Ingredient::isActive()->orderBy('name')->get();
        return $this->makePartial('ingredients/add_movement_modal', ['ingredients' => $ingredients]);
    }

    public function onAddMovement()
    {
        $data = post();
        
        $rules = [
            'ingredient_id' => 'required|exists:Paolorox\Restapro\Models\Ingredient,id',
            'type' => 'required|in:waste,adjustment',
            'quantity' => 'required|numeric',
        ];

        $validation = \Illuminate\Support\Facades\Validator::make($data, $rules);

        if ($validation->fails()) {
            throw new \Igniter\System\Exceptions\ValidationException($validation);
        }

        $ingredient = \Paolorox\Restapro\Models\Ingredient::find($data['ingredient_id']);
        $engine = app(\Paolorox\Restapro\Services\InventoryEngine::class);

        if ($data['type'] === 'waste') {
            // quantity should be negative for waste, but we handle it via InventoryEngine depending on how it's defined
            // InventoryEngine->recordWaste takes absolute quantity and negates it.
            $engine->recordWaste($ingredient, $data['quantity'], $data['notes'] ?? null);
        } else {
            // Adjustment allows positive or negative
            $engine->adjustStock($ingredient, $data['quantity'], $data['notes'] ?? null);
        }

        flash()->success(lang('paolorox.restapro::default.alert_movement_added'));

        return $this->redirect('paolorox/restapro/ingredients');
    }
}
