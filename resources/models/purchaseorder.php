<?php

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'save' => [
                    'label' => 'lang:admin::lang.button_save',
                    'class' => 'btn btn-primary',
                    'data-request' => 'onSave',
                ],
                'saveClose' => [
                    'label' => 'lang:admin::lang.button_save_close',
                    'class' => 'btn btn-default',
                    'data-request' => 'onSave',
                    'data-request-data' => 'close:1',
                ],
                'receive' => [
                    'label' => 'lang:paolorox.restapro::default.button_mark_received',
                    'class' => 'btn btn-success',
                    'data-request' => 'onReceiveOrder',
                    'data-request-confirm' => 'lang:paolorox.restapro::default.purchase_order_receive_confirm',
                    'context' => 'edit',
                ],
                'delete' => [
                    'label' => 'lang:admin::lang.button_icon_delete',
                    'class' => 'btn btn-danger',
                    'data-request' => 'onDelete',
                    'data-request-confirm' => 'lang:admin::lang.alert_warning_confirm',
                    'context' => 'edit',
                ],
            ],
        ],
        'fields' => [
            'supplier_id' => [
                'label' => 'lang:paolorox.restapro::default.purchase_order_supplier',
                'type' => 'relation',
                'relationFrom' => 'supplier',
                'nameFrom' => 'name',
                'span' => 'left',
                'required' => true,
                'placeholder' => 'lang:paolorox.restapro::default.text_select',
            ],
            'reference' => [
                'label' => 'lang:paolorox.restapro::default.purchase_order_reference',
                'type' => 'text',
                'span' => 'right',
            ],
            'status' => [
                'label' => 'lang:paolorox.restapro::default.purchase_order_status',
                'type' => 'radiotoggle',
                'span' => 'left',
                'default' => 'draft',
                'options' => [
                    'draft' => 'lang:paolorox.restapro::default.purchase_order_status_draft',
                    'ordered' => 'lang:paolorox.restapro::default.purchase_order_status_ordered',
                    'received' => 'lang:paolorox.restapro::default.purchase_order_status_received',
                    'cancelled' => 'lang:paolorox.restapro::default.purchase_order_status_cancelled',
                ],
            ],
            'order_date' => [
                'label' => 'lang:paolorox.restapro::default.purchase_order_order_date',
                'type' => 'datepicker',
                'span' => 'left',
                'mode' => 'date',
            ],
            'received_date' => [
                'label' => 'lang:paolorox.restapro::default.purchase_order_received_date',
                'type' => 'datepicker',
                'span' => 'right',
                'mode' => 'date',
            ],
            'total_cost' => [
                'label' => 'lang:paolorox.restapro::default.purchase_order_total_cost',
                'type' => 'money',
                'span' => 'left',
                'disabled' => true,
            ],
            'notes' => [
                'label' => 'lang:paolorox.restapro::default.purchase_order_notes',
                'type' => 'textarea',
                'span' => 'full',
                'attributes' => ['rows' => 3],
            ],
        ],
        'tabs' => [
            'fields' => [
                'items' => [
                    'label' => 'lang:paolorox.restapro::default.purchase_order_items_tab',
                    'type' => 'repeater',
                    'tab' => 'lang:paolorox.restapro::default.tab_items',
                    'sortable' => false,
                    'prompt' => 'lang:paolorox.restapro::default.purchase_order_add_item',
                    'showAddButton' => true,
                    'showRemoveButton' => true,
                    'form' => [
                        'fields' => [
                            'ingredient_id' => [
                                'label' => 'lang:paolorox.restapro::default.purchase_order_item_ingredient',
                                'type' => 'select',
                                'span' => 'left',
                                'options' => [\Paolorox\Restapro\Models\Ingredient::class, 'getDropdownOptions'],
                                'required' => true,
                            ],
                            'quantity' => [
                                'label' => 'lang:paolorox.restapro::default.purchase_order_item_quantity',
                                'type' => 'number',
                                'span' => 'right',
                                'required' => true,
                            ],
                            'unit_cost' => [
                                'label' => 'lang:paolorox.restapro::default.purchase_order_item_unit_cost',
                                'type' => 'money',
                                'span' => 'left',
                                'required' => true,
                            ],
                            'unit_id' => [
                                'label' => 'lang:paolorox.restapro::default.purchase_order_item_unit',
                                'type' => 'select',
                                'span' => 'right',
                                'options' => [\Paolorox\Restapro\Models\Unit::class, 'getDropdownOptions'],
                                'required' => true,
                            ],
                            'expiry_date' => [
                                'label' => 'lang:paolorox.restapro::default.purchase_order_item_expiry_date',
                                'type' => 'datepicker',
                                'span' => 'left',
                                'mode' => 'date',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'list' => [
        'toolbar' => [
            'buttons' => [
                'new' => [
                    'label' => 'lang:paolorox.restapro::default.button_new_purchase_order',
                    'class' => 'btn btn-primary',
                    'href' => 'paolorox/restapro/purchaseorders/create',
                ],
            ],
        ],
        'filter' => [
            'search' => [
                'prompt' => 'lang:paolorox.restapro::default.purchase_order_title',
                'mode' => 'all',
            ],
            'scopes' => [
                'status' => [
                    'label' => 'lang:paolorox.restapro::default.purchase_order_status',
                    'type' => 'select',
                    'conditions' => 'status = :filtered',
                    'options' => [
                        'draft' => 'lang:paolorox.restapro::default.purchase_order_status_draft',
                        'ordered' => 'lang:paolorox.restapro::default.purchase_order_status_ordered',
                        'received' => 'lang:paolorox.restapro::default.purchase_order_status_received',
                        'cancelled' => 'lang:paolorox.restapro::default.purchase_order_status_cancelled',
                    ],
                ],
            ],
        ],
        'columns' => [
            'edit' => [
                'type' => 'button',
                'iconCssClass' => 'fa fa-pencil',
                'attributes' => [
                    'class' => 'btn btn-edit',
                    'href' => 'paolorox/restapro/purchaseorders/edit/{id}',
                ],
            ],
            'id' => [
                'label' => '#',
            ],
            'supplier_name' => [
                'label' => 'lang:paolorox.restapro::default.purchase_order_supplier',
                'relation' => 'supplier',
                'valueFrom' => 'name',
                'searchable' => true,
                'sortable' => false,
            ],
            'reference' => [
                'label' => 'lang:paolorox.restapro::default.purchase_order_reference',
                'searchable' => true,
            ],
            'status' => [
                'label' => 'lang:paolorox.restapro::default.purchase_order_status',
            ],
            'total_cost' => [
                'label' => 'lang:paolorox.restapro::default.purchase_order_total_cost',
                'type' => 'money',
            ],
            'order_date' => [
                'label' => 'lang:paolorox.restapro::default.purchase_order_order_date',
                'type' => 'date',
            ],
            'created_at' => [
                'label' => 'lang:paolorox.restapro::default.stock_movement_date',
                'type' => 'timetense',
            ],
        ],
    ],
];
