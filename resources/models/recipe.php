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
                'label' => 'lang:paolorox.restapro::default.recipe_name',
                'type' => 'text',
                'span' => 'left',
                'required' => true,
            ],
            'type' => [
                'label' => 'lang:paolorox.restapro::default.recipe_type',
                'type' => 'radiotoggle',
                'span' => 'right',
                'default' => 'menu_item',
                'options' => [
                    'menu_item' => 'lang:paolorox.restapro::default.recipe_type_menu_item',
                    'sub_recipe' => 'lang:paolorox.restapro::default.recipe_type_sub_recipe',
                ],
            ],
            'menu_id' => [
                'label' => 'lang:paolorox.restapro::default.recipe_menu_id',
                'type' => 'relation',
                'relationFrom' => 'menu',
                'nameFrom' => 'menu_name',
                'span' => 'left',
                'placeholder' => 'lang:paolorox.restapro::default.text_select',
                'trigger' => [
                    'action' => 'show',
                    'field' => 'type',
                    'condition' => 'value[menu_item]',
                ],
            ],
            'is_active' => [
                'label' => 'lang:paolorox.restapro::default.recipe_is_active',
                'type' => 'switch',
                'span' => 'left',
                'default' => true,
            ],
            'real_margin' => [
                'type' => 'partial',
                'path' => 'paolorox.restapro::recipes.margin',
            ],
            'yield_amount' => [
                'label' => 'lang:paolorox.restapro::default.recipe_yield_amount',
                'type' => 'number',
                'span' => 'left',
                'default' => 1,
            ],
            'yield_unit_id' => [
                'label' => 'lang:paolorox.restapro::default.recipe_yield_unit',
                'type' => 'relation',
                'relationFrom' => 'yieldUnit',
                'nameFrom' => 'name',
                'span' => 'right',
                'placeholder' => 'lang:paolorox.restapro::default.text_select',
            ],
            'target_food_cost' => [
                'label' => 'lang:paolorox.restapro::default.recipe_target_food_cost',
                'type' => 'number',
                'span' => 'left',
                'default' => 30,
            ],
            'calculated_cost' => [
                'label' => 'lang:paolorox.restapro::default.recipe_calculated_cost',
                'type' => 'money',
                'span' => 'right',
                'disabled' => true,
            ],
        ],
        'tabs' => [
            'fields' => [
                'recipeIngredients' => [
                    'label' => 'lang:paolorox.restapro::default.recipe_ingredients_tab',
                    'type' => 'repeater',
                    'tab' => 'lang:paolorox.restapro::default.tab_ingredients',
                    'sortable' => false,
                    'prompt' => 'lang:paolorox.restapro::default.recipe_add_ingredient',
                    'showAddButton' => true,
                    'showRemoveButton' => true,
                    'form' => [
                        'fields' => [
                            'ingredient_id' => [
                                'label' => 'lang:paolorox.restapro::default.recipe_ingredient_ingredient',
                                'type' => 'select',
                                'span' => 'left',
                                'options' => [\Paolorox\Restapro\Models\Ingredient::class, 'getDropdownOptions'],
                                'placeholder' => 'lang:paolorox.restapro::default.text_select',
                            ],
                            'sub_recipe_id' => [
                                'label' => 'lang:paolorox.restapro::default.recipe_ingredient_sub_recipe',
                                'type' => 'select',
                                'span' => 'right',
                                'options' => [\Paolorox\Restapro\Models\Recipe::class, 'getSubRecipeOptions'],
                                'placeholder' => 'lang:paolorox.restapro::default.text_none',
                            ],
                            'quantity' => [
                                'label' => 'lang:paolorox.restapro::default.recipe_ingredient_quantity',
                                'type' => 'number',
                                'span' => 'left',
                                'required' => true,
                            ],
                            'unit_id' => [
                                'label' => 'lang:paolorox.restapro::default.recipe_ingredient_unit',
                                'type' => 'select',
                                'span' => 'right',
                                'options' => [\Paolorox\Restapro\Models\Unit::class, 'getDropdownOptions'],
                                'placeholder' => 'lang:paolorox.restapro::default.text_select',
                            ],
                        ],
                    ],
                ],
                'instructions' => [
                    'label' => 'lang:paolorox.restapro::default.recipe_instructions',
                    'type' => 'textarea',
                    'tab' => 'lang:paolorox.restapro::default.tab_instructions',
                    'attributes' => [
                        'rows' => 8,
                    ],
                ],
            ],
        ],
    ],
    'list' => [
        'toolbar' => [
            'buttons' => [
                'new' => [
                    'label' => 'lang:paolorox.restapro::default.button_new_recipe',
                    'class' => 'btn btn-primary',
                    'href' => 'paolorox/restapro/recipes/create',
                ],
            ],
        ],
        'filter' => [
            'search' => [
                'prompt' => 'lang:paolorox.restapro::default.recipe_title',
                'mode' => 'all',
            ],
            'scopes' => [
                'type' => [
                    'label' => 'lang:paolorox.restapro::default.recipe_type',
                    'type' => 'select',
                    'conditions' => 'type = :filtered',
                    'options' => [
                        'menu_item' => 'lang:paolorox.restapro::default.recipe_type_menu_item',
                        'sub_recipe' => 'lang:paolorox.restapro::default.recipe_type_sub_recipe',
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
                    'href' => 'paolorox/restapro/recipes/edit/{id}',
                ],
            ],
            'name' => [
                'label' => 'lang:paolorox.restapro::default.recipe_name',
                'searchable' => true,
            ],
            'type' => [
                'label' => 'lang:paolorox.restapro::default.recipe_type',
            ],
            'calculated_cost' => [
                'label' => 'lang:paolorox.restapro::default.recipe_calculated_cost',
                'type' => 'money',
            ],
            'target_food_cost' => [
                'label' => 'lang:paolorox.restapro::default.recipe_target_food_cost',
                'type' => 'text',
            ],
            'yield_amount' => [
                'label' => 'lang:paolorox.restapro::default.recipe_yield_amount',
                'type' => 'text',
            ],
            'is_active' => [
                'label' => 'lang:paolorox.restapro::default.ingredient_is_active',
                'type' => 'switch',
            ],
        ],
    ],
];
