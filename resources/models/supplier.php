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
                'label' => 'lang:paolorox.restapro::default.supplier_name',
                'type' => 'text',
                'span' => 'left',
                'required' => true,
            ],
            'contact_name' => [
                'label' => 'lang:paolorox.restapro::default.supplier_contact_name',
                'type' => 'text',
                'span' => 'right',
            ],
            'email' => [
                'label' => 'lang:paolorox.restapro::default.supplier_email',
                'type' => 'email',
                'span' => 'left',
            ],
            'phone' => [
                'label' => 'lang:paolorox.restapro::default.supplier_phone',
                'type' => 'text',
                'span' => 'right',
            ],
            'address' => [
                'label' => 'lang:paolorox.restapro::default.supplier_address',
                'type' => 'textarea',
                'span' => 'full',
                'attributes' => ['rows' => 3],
            ],
            'notes' => [
                'label' => 'lang:paolorox.restapro::default.supplier_notes',
                'type' => 'textarea',
                'span' => 'full',
                'attributes' => ['rows' => 3],
            ],
            'is_active' => [
                'label' => 'lang:paolorox.restapro::default.supplier_is_active',
                'type' => 'switch',
                'span' => 'left',
                'default' => true,
            ],
        ],
    ],
    'list' => [
        'toolbar' => [
            'buttons' => [
                'new' => [
                    'label' => 'lang:paolorox.restapro::default.button_new_supplier',
                    'class' => 'btn btn-primary',
                    'href' => 'paolorox/restapro/suppliers/create',
                ],
            ],
        ],
        'filter' => [
            'search' => [
                'prompt' => 'lang:paolorox.restapro::default.supplier_title',
                'mode' => 'all',
            ],
        ],
        'columns' => [
            'edit' => [
                'type' => 'button',
                'iconCssClass' => 'fa fa-pencil',
                'attributes' => [
                    'class' => 'btn btn-edit',
                    'href' => 'paolorox/restapro/suppliers/edit/{id}',
                ],
            ],
            'name' => [
                'label' => 'lang:paolorox.restapro::default.supplier_name',
                'searchable' => true,
            ],
            'contact_name' => [
                'label' => 'lang:paolorox.restapro::default.supplier_contact_name',
                'searchable' => true,
            ],
            'email' => [
                'label' => 'lang:paolorox.restapro::default.supplier_email',
            ],
            'phone' => [
                'label' => 'lang:paolorox.restapro::default.supplier_phone',
            ],
            'is_active' => [
                'label' => 'lang:paolorox.restapro::default.supplier_is_active',
                'type' => 'switch',
            ],
        ],
    ],
];
