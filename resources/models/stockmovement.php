<?php

return [
    'list' => [
        'toolbar' => [
            'buttons' => [
                'create' => [
                    'label' => 'lang:igniter::admin.button_new',
                    'class' => 'btn btn-primary',
                    'href' => 'paolorox/restapro/stockmovements/create',
                ],
                'export' => [
                    'label' => 'Export CSV',
                    'class' => 'btn btn-default',
                    'href' => 'paolorox/restapro/stockmovements/exportcsv',
                ],
            ],
        ],
        'filter' => [
            'search' => [
                'prompt' => 'lang:paolorox.restapro::default.stock_movement_title',
                'mode' => 'all',
            ],
            'scopes' => [
                'type' => [
                    'label' => 'lang:paolorox.restapro::default.stock_movement_type',
                    'type' => 'select',
                    'conditions' => 'type = :filtered',
                    'options' => [
                        'purchase' => 'lang:paolorox.restapro::default.stock_movement_type_purchase',
                        'sale' => 'lang:paolorox.restapro::default.stock_movement_type_sale',
                        'waste' => 'lang:paolorox.restapro::default.stock_movement_type_waste',
                        'adjustment' => 'lang:paolorox.restapro::default.stock_movement_type_adjustment',
                    ],
                ],
            ],
        ],
        'columns' => [
            'created_at' => [
                'label' => 'lang:paolorox.restapro::default.stock_movement_date',
                'type' => 'timetense',
            ],
            'ingredient_name' => [
                'label' => 'lang:paolorox.restapro::default.stock_movement_ingredient',
                'relation' => 'ingredient',
                'valueFrom' => 'name',
                'searchable' => true,
                'sortable' => false,
            ],
            'type' => [
                'label' => 'lang:paolorox.restapro::default.stock_movement_type',
            ],
            'quantity' => [
                'label' => 'lang:paolorox.restapro::default.stock_movement_quantity',
                'type' => 'text',
            ],
            'unit_cost' => [
                'label' => 'lang:paolorox.restapro::default.stock_movement_unit_cost',
                'type' => 'money',
            ],
            'reference_id' => [
                'label' => 'lang:paolorox.restapro::default.stock_movement_reference',
            ],
            'notes' => [
                'label' => 'lang:paolorox.restapro::default.stock_movement_notes',
                'invisible' => true,
            ],
        ],
    ],
    'form' => [
        'toolbar' => [
            'buttons' => [
                'save' => [
                    'label' => 'lang:igniter::admin.button_save',
                    'class' => 'btn btn-primary',
                    'data-request' => 'onSave',
                    'data-progress-indicator' => 'lang:igniter::admin.text_saving',
                ],
                'saveClose' => [
                    'label' => 'lang:igniter::admin.button_save_close',
                    'class' => 'btn btn-default',
                    'data-request' => 'onSave',
                    'data-request-data' => 'close:1',
                    'data-progress-indicator' => 'lang:igniter::admin.text_saving',
                ],
            ],
        ],
        'fields' => [
            'ingredient_id' => [
                'label' => 'lang:paolorox.restapro::default.stock_movement_ingredient',
                'type' => 'relation',
                'relationFrom' => 'ingredient',
                'nameFrom' => 'name',
                'span' => 'left',
            ],
            'type' => [
                'label' => 'lang:paolorox.restapro::default.stock_movement_type',
                'type' => 'select',
                'span' => 'right',
                'options' => [
                    'purchase' => 'lang:paolorox.restapro::default.stock_movement_type_purchase',
                    'sale' => 'lang:paolorox.restapro::default.stock_movement_type_sale',
                    'waste' => 'lang:paolorox.restapro::default.stock_movement_type_waste',
                    'adjustment' => 'lang:paolorox.restapro::default.stock_movement_type_adjustment',
                ],
            ],
            'quantity' => [
                'label' => 'lang:paolorox.restapro::default.stock_movement_quantity',
                'type' => 'number',
                'span' => 'left',
            ],
            'unit_cost' => [
                'label' => 'lang:paolorox.restapro::default.stock_movement_unit_cost',
                'type' => 'currency',
                'span' => 'right',
            ],
            'notes' => [
                'label' => 'lang:paolorox.restapro::default.stock_movement_notes',
                'type' => 'textarea',
                'span' => 'full',
            ],
        ],
    ],
];
