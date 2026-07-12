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
                'label' => 'lang:paolorox.restapro::default.category_name',
                'type' => 'text',
                'span' => 'left',
                'required' => true,
            ],
            'is_active' => [
                'label' => 'lang:paolorox.restapro::default.category_is_active',
                'type' => 'switch',
                'span' => 'right',
                'default' => true,
            ],
            'description' => [
                'label' => 'lang:paolorox.restapro::default.category_description',
                'type' => 'textarea',
                'span' => 'full',
                'attributes' => ['rows' => 3],
            ],
            'Linked Ingredients' => [
                'ingredients_list' => [
                    'tab' => 'Linked Ingredients',
                    'type' => 'partial',
                    'path' => 'paolorox.restapro::categories.ingredients',
                ],
            ],
        ],
    ],
    'list' => [
        'toolbar' => [
            'buttons' => [
                'new' => [
                    'label' => 'lang:paolorox.restapro::default.button_new_category',
                    'class' => 'btn btn-primary',
                    'href' => 'paolorox/restapro/categories/create',
                ],
            ],
        ],
        'filter' => [
            'search' => [
                'prompt' => 'lang:paolorox.restapro::default.category_title',
                'mode' => 'all',
            ],
        ],
        'columns' => [
            'edit' => [
                'type' => 'button',
                'iconCssClass' => 'fa fa-pencil',
                'attributes' => [
                    'class' => 'btn btn-edit',
                    'href' => 'paolorox/restapro/categories/edit/{id}',
                ],
            ],
            'name' => [
                'label' => 'lang:paolorox.restapro::default.category_name',
                'searchable' => true,
            ],
            'description' => [
                'label' => 'lang:paolorox.restapro::default.category_description',
            ],
            'is_active' => [
                'label' => 'lang:paolorox.restapro::default.category_is_active',
                'type' => 'switch',
            ],
        ],
    ],
];
