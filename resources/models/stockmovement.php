<?php

return [
    'list' => [
        'toolbar' => [
            'buttons' => [],
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
];
