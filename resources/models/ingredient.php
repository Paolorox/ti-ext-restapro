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
            'name' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_name',
                'type' => 'text',
                'span' => 'left',
                'required' => true,
            ],
            'sku' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_sku',
                'type' => 'text',
                'span' => 'right',
            ],
            'category_id' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_category',
                'type' => 'relation',
                'relationFrom' => 'category',
                'nameFrom' => 'name',
                'span' => 'left',
                'placeholder' => 'lang:paolorox.restapro::default.text_select',
            ],
            'unit_id' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_unit',
                'type' => 'relation',
                'relationFrom' => 'unit',
                'nameFrom' => 'name',
                'span' => 'right',
                'required' => true,
                'placeholder' => 'lang:paolorox.restapro::default.text_select',
            ],
            'supplier_id' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_supplier',
                'type' => 'relation',
                'relationFrom' => 'supplier',
                'nameFrom' => 'name',
                'span' => 'left',
                'placeholder' => 'lang:paolorox.restapro::default.text_select',
            ],
            'is_active' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_is_active',
                'type' => 'switch',
                'span' => 'right',
                'default' => true,
            ],
        ],
        'tabs' => [
            'fields' => [
                'average_cost' => [
                    'label' => 'lang:paolorox.restapro::default.ingredient_average_cost',
                    'type' => 'money',
                    'span' => 'left',
                    'tab' => 'lang:paolorox.restapro::default.tab_costs_stock',
                    'disabled' => true,
                ],
                'last_cost' => [
                    'label' => 'lang:paolorox.restapro::default.ingredient_last_cost',
                    'type' => 'money',
                    'span' => 'right',
                    'tab' => 'lang:paolorox.restapro::default.tab_costs_stock',
                    'disabled' => true,
                ],
                'stock' => [
                    'label' => 'lang:paolorox.restapro::default.ingredient_stock',
                    'type' => 'number',
                    'span' => 'left',
                    'tab' => 'lang:paolorox.restapro::default.tab_costs_stock',
                ],
                'minimum_stock' => [
                    'label' => 'lang:paolorox.restapro::default.ingredient_minimum_stock',
                    'type' => 'number',
                    'span' => 'right',
                    'tab' => 'lang:paolorox.restapro::default.tab_costs_stock',
                ],
                'expiry_date' => [
                    'label' => 'lang:paolorox.restapro::default.ingredient_expiry_date',
                    'type' => 'datepicker',
                    'mode' => 'date',
                    'span' => 'left',
                    'tab' => 'lang:paolorox.restapro::default.tab_costs_stock',
                ],
                'expiry_alert_days' => [
                    'label' => 'lang:paolorox.restapro::default.ingredient_expiry_alert_days',
                    'type' => 'number',
                    'span' => 'right',
                    'default' => 3,
                    'tab' => 'lang:paolorox.restapro::default.tab_costs_stock',
                ],
                'yield_percentage' => [
                    'label' => 'lang:paolorox.restapro::default.ingredient_yield',
                    'type' => 'number',
                    'span' => 'left',
                    'default' => 100,
                    'comment' => 'lang:paolorox.restapro::default.ingredient_yield_comment',
                    'tab' => 'lang:paolorox.restapro::default.tab_costs_stock',
                ],
            ],
            'History & Usage' => [
                'recent_movements' => [
                    'tab' => 'History & Usage',
                    'type' => 'partial',
                    'path' => 'paolorox.restapro::ingredients.history',
                ],
                'linked_recipes' => [
                    'tab' => 'History & Usage',
                    'type' => 'partial',
                    'path' => 'paolorox.restapro::ingredients.recipes',
                ],
            ],
        ],
    ],
    'list' => [
        'toolbar' => [
            'buttons' => [
                'new' => [
                    'label' => 'lang:paolorox.restapro::default.button_new_ingredient',
                    'class' => 'btn btn-primary',
                    'href' => 'paolorox/restapro/ingredients/create',
                ],
                'add_movement' => [
                    'label' => 'lang:paolorox.restapro::default.button_add_movement',
                    'class' => 'btn btn-default',
                    'href' => 'paolorox/restapro/stockmovements/create',
                ],
                'export' => [
                    'label' => 'Export CSV',
                    'class' => 'btn btn-default',
                    'href' => 'paolorox/restapro/ingredients/exportcsv',
                ],
            ],
        ],
        'filter' => [
            'search' => [
                'prompt' => 'lang:paolorox.restapro::default.ingredient_title',
                'mode' => 'all',
            ],
            'scopes' => [
                'category' => [
                    'label' => 'lang:paolorox.restapro::default.ingredient_category',
                    'type' => 'select',
                    'scope' => 'byCategory',
                    'modelClass' => \Paolorox\Restapro\Models\Category::class,
                    'nameFrom' => 'name',
                ],
                'supplier' => [
                    'label' => 'lang:paolorox.restapro::default.ingredient_supplier',
                    'type' => 'select',
                    'scope' => 'bySupplier',
                    'modelClass' => \Paolorox\Restapro\Models\Supplier::class,
                    'nameFrom' => 'name',
                ],
                'status' => [
                    'label' => 'lang:paolorox.restapro::default.ingredient_is_active',
                    'type' => 'switch',
                    'conditions' => 'is_active = :filtered',
                ],
            ],
        ],
        'columns' => [
            'edit' => [
                'type' => 'button',
                'iconCssClass' => 'fa fa-pencil',
                'attributes' => [
                    'class' => 'btn btn-edit',
                    'href' => 'paolorox/restapro/ingredients/edit/{id}',
                ],
            ],
            'name' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_name',
                'searchable' => true,
            ],
            'sku' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_sku',
                'searchable' => true,
            ],
            'category_name' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_category',
                'relation' => 'category',
                'valueFrom' => 'name',
                'sortable' => false,
            ],
            'unit_abbreviation' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_unit',
                'relation' => 'unit',
                'valueFrom' => 'abbreviation',
                'sortable' => false,
            ],
            'stock' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_stock',
                'type' => 'text',
            ],
            'expiry_date' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_expiry_date',
                'type' => 'date',
            ],
            'average_cost' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_average_cost',
                'type' => 'money',
            ],
            'is_active' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_is_active',
                'type' => 'switch',
            ],
        ],
    ],
];
