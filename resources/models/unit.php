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
                'label' => 'lang:paolorox.restapro::default.unit_name',
                'type' => 'text',
                'span' => 'left',
                'required' => true,
            ],
            'abbreviation' => [
                'label' => 'lang:paolorox.restapro::default.unit_abbreviation',
                'type' => 'text',
                'span' => 'right',
                'required' => true,
            ],
            'type' => [
                'label' => 'lang:paolorox.restapro::default.unit_type',
                'type' => 'radiotoggle',
                'span' => 'left',
                'required' => true,
                'options' => [
                    'weight' => 'lang:paolorox.restapro::default.unit_type_weight',
                    'volume' => 'lang:paolorox.restapro::default.unit_type_volume',
                    'piece' => 'lang:paolorox.restapro::default.unit_type_piece',
                ],
            ],
            'conversion_factor' => [
                'label' => 'lang:paolorox.restapro::default.unit_conversion_factor',
                'type' => 'number',
                'span' => 'right',
                'default' => 1,
            ],
            'base_unit_id' => [
                'label' => 'lang:paolorox.restapro::default.unit_base_unit',
                'type' => 'relation',
                'relationFrom' => 'baseUnit',
                'nameFrom' => 'name',
                'span' => 'left',
                'placeholder' => 'lang:paolorox.restapro::default.text_none',
            ],
            'is_active' => [
                'label' => 'lang:paolorox.restapro::default.unit_is_active',
                'type' => 'switch',
                'span' => 'right',
                'default' => true,
            ],
        ],
    ],
    'list' => [
        'toolbar' => [
            'buttons' => [
                'new' => [
                    'label' => 'lang:paolorox.restapro::default.button_new_unit',
                    'class' => 'btn btn-primary',
                    'href' => 'paolorox/restapro/units/create',
                ],
            ],
        ],
        'filter' => [
            'search' => [
                'prompt' => 'lang:paolorox.restapro::default.unit_title',
                'mode' => 'all',
            ],
        ],
        'columns' => [
            'edit' => [
                'type' => 'button',
                'iconCssClass' => 'fa fa-pencil',
                'attributes' => [
                    'class' => 'btn btn-edit',
                    'href' => 'paolorox/restapro/units/edit/{id}',
                ],
            ],
            'name' => [
                'label' => 'lang:paolorox.restapro::default.unit_name',
                'searchable' => true,
            ],
            'abbreviation' => [
                'label' => 'lang:paolorox.restapro::default.unit_abbreviation',
            ],
            'type' => [
                'label' => 'lang:paolorox.restapro::default.unit_type',
            ],
            'conversion_factor' => [
                'label' => 'lang:paolorox.restapro::default.unit_conversion_factor',
            ],
            'is_active' => [
                'label' => 'lang:paolorox.restapro::default.unit_is_active',
                'type' => 'switch',
            ],
        ],
    ],
];
