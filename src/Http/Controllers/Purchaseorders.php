<?php

namespace Paolorox\Restapro\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Flame\Exception\ApplicationException;
use Paolorox\Restapro\Models\PurchaseOrder;

class Purchaseorders extends AdminController
{
    public array $implement = [
        \Igniter\Admin\Http\Actions\ListController::class,
        \Igniter\Admin\Http\Actions\FormController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => \Paolorox\Restapro\Models\PurchaseOrder::class,
            'title' => 'paolorox.restapro::default.purchase_order_title',
            'emptyMessage' => 'paolorox.restapro::default.text_empty',
            'defaultSort' => ['created_at', 'DESC'],
            'configFile' => 'purchaseorder',
            'recordUrl' => 'paolorox/restapro/purchaseorders/edit/{id}',
        ],
    ];

    public array $formConfig = [
        'name' => 'paolorox.restapro::default.purchase_order_title',
        'model' => \Paolorox\Restapro\Models\PurchaseOrder::class,
        'request' => \Paolorox\Restapro\Http\Requests\PurchaseOrderRequest::class,
        'create' => [
            'title' => 'lang:admin::lang.text_new',
            'redirect' => 'paolorox/restapro/purchaseorders/edit/{id}',
            'redirectClose' => 'paolorox/restapro/purchaseorders',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.text_edit',
            'redirect' => 'paolorox/restapro/purchaseorders/edit/{id}',
            'redirectClose' => 'paolorox/restapro/purchaseorders',
        ],
        'configFile' => 'purchaseorder',
    ];

    public null|string|array $requiredPermissions = ['Paolorox.Restapro.ManagePurchaseOrders'];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('paolorox.restapro', 'restapro', 'purchaseorders');
    }

    /**
     * AJAX handler: marca il PO come ricevuto e genera i movimenti di magazzino.
     *
     * In TastyIgniter il record ID di una pagina form arriva come primo
     * parametro della rotta (come edit($recordId)), non da post('recordId').
     */
    public function onReceiveOrder($recordId = null)
    {
        $recordId = $recordId ?: post('recordId');
        $purchaseOrder = PurchaseOrder::findOrFail($recordId);

        if ($purchaseOrder->status === PurchaseOrder::STATUS_RECEIVED) {
            throw new ApplicationException(
                lang('paolorox.restapro::default.purchase_order_already_received')
            );
        }

        // Impostando lo stato a "received" e salvando, il model si occupa
        // automaticamente di generare i movimenti di magazzino (afterSave).
        $purchaseOrder->status = PurchaseOrder::STATUS_RECEIVED;
        $purchaseOrder->save();

        flash()->success(lang('paolorox.restapro::default.purchase_order_received_success'));

        return $this->redirectBack();
    }
}
