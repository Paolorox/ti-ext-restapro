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
            ],
        ],
        'fields' => [
            '_tabs' => [
                'type' => 'partial',
                'path' => 'paolorox.restapro::partials/settings_tabs',
                'span' => 'full',
            ],
            'currency_symbol' => [
                'label' => 'lang:paolorox.restapro::default.settings_currency_symbol',
                'type' => 'text',
                'span' => 'left',
                'default' => '€',
            ],
            'currency_format' => [
                'label' => 'lang:paolorox.restapro::default.settings_currency_format',
                'type' => 'radio',
                'span' => 'right',
                'default' => 'left',
                'options' => [
                    'left' => 'lang:paolorox.restapro::default.settings_currency_left',
                    'right' => 'lang:paolorox.restapro::default.settings_currency_right',
                ],
            ],
            'enable_auto_stock_deduction' => [
                'label' => 'lang:paolorox.restapro::default.settings_auto_stock_deduction',
                'type' => 'switch',
                'span' => 'left',
                'default' => true,
                'comment' => 'lang:paolorox.restapro::default.settings_auto_stock_deduction_comment',
            ],
            'default_minimum_stock' => [
                'label' => 'lang:paolorox.restapro::default.settings_default_min_stock',
                'type' => 'number',
                'span' => 'right',
                'default' => 0,
            ],
        ],
    ],
];
