<?php

namespace Paolorox\Restapro\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;

class StockMovements extends AdminController
{
    public array $implement = [
        \Igniter\Admin\Http\Actions\ListController::class,
        \Igniter\Admin\Http\Actions\FormController::class,
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

    public array $formConfig = [
        'name' => 'Stock Movement',
        'model' => \Paolorox\Restapro\Models\StockMovement::class,
        'request' => \Paolorox\Restapro\Http\Requests\StockMovementRequest::class,
        'create' => [
            'title' => 'lang:igniter::admin.form.create_title',
            'redirect' => 'paolorox/restapro/stockmovements/edit/{id}',
            'redirectClose' => 'paolorox/restapro/stockmovements',
            'redirectNew' => 'paolorox/restapro/stockmovements/create',
        ],
        'edit' => [
            'title' => 'lang:igniter::admin.form.edit_title',
            'redirect' => 'paolorox/restapro/stockmovements/edit/{id}',
            'redirectClose' => 'paolorox/restapro/stockmovements',
            'redirectNew' => 'paolorox/restapro/stockmovements/create',
        ],
        'preview' => [
            'title' => 'lang:igniter::admin.form.preview_title',
            'redirect' => 'paolorox/restapro/stockmovements',
        ],
        'delete' => [
            'redirect' => 'paolorox/restapro/stockmovements',
        ],
        'configFile' => 'stockmovement',
    ];

    public null|string|array $requiredPermissions = ['Paolorox.Restapro.ViewStockMovements'];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('paolorox.restapro', 'restapro', 'stockmovements');
    }

    public function formExtendFields($form)
    {
        if ($form->context === 'create' && request()->has('type')) {
            $typeField = $form->getField('type');
            if ($typeField) {
                $typeField->value = request()->input('type');
            }
        }
    }

    public function exportCsv()
    {
        $movements = \Paolorox\Restapro\Models\StockMovement::with(['ingredient', 'ingredient.unit'])->orderBy('created_at', 'desc')->get();
        $csv = "ID,Date,Ingredient,Type,Quantity,Unit,Unit Cost,Total Value,Notes\n";
        
        foreach ($movements as $m) {
            $unit = $m->ingredient && $m->ingredient->unit ? $m->ingredient->unit->abbreviation : '';
            $totalValue = $m->quantity * $m->unit_cost;
            $ingredientName = $m->ingredient ? str_replace('"', '""', $m->ingredient->name) : '';
            $notes = str_replace('"', '""', $m->notes);
            $date = $m->created_at ? $m->created_at->format('Y-m-d H:i') : '';
            
            $csv .= "{$m->id},{$date},\"{$ingredientName}\",{$m->type},{$m->quantity},\"{$unit}\",{$m->unit_cost},{$totalValue},\"{$notes}\"\n";
        }
        
        return \Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="stock_movements_'.date('Y-m-d').'.csv"',
        ]);
    }
}
