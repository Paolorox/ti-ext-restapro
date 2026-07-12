<?php

namespace Paolorox\Restapro;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Igniter\System\Classes\BaseExtension;

class Extension extends BaseExtension
{
    public function register(): void
    {
        parent::register();

        // Registra i servizi nel container come singleton
        $this->app->singleton(
            \Paolorox\Restapro\Services\UnitConversionService::class,
            \Paolorox\Restapro\Services\UnitConversionService::class
        );

        $this->app->singleton(
            \Paolorox\Restapro\Services\InventoryEngine::class,
            \Paolorox\Restapro\Services\InventoryEngine::class
        );

        $this->app->singleton(
            \Paolorox\Restapro\Services\RecipeResolverService::class,
            \Paolorox\Restapro\Services\RecipeResolverService::class
        );
    }

    public function boot(): void
    {
        $viewsDir = __DIR__.'/../resources/views';
        $langDir = __DIR__.'/../resources/lang';

        $this->loadViewsFrom($viewsDir, 'paolorox.restapro');
        $this->loadTranslationsFrom($langDir, 'paolorox.restapro');

        if (app()->bound('translator')) {
            app('translator')->addNamespace('paolorox.restapro', $langDir);
        }

        // Registra l'Observer per i movimenti di magazzino
        \Paolorox\Restapro\Models\StockMovement::observe(
            \Paolorox\Restapro\Observers\StockMovementObserver::class
        );

        // Event Listener: Scarico automatico ingredienti alla conferma ordine
        Event::listen('admin.order.paymentProcessed', function ($order) {
            try {
                $resolver = app(\Paolorox\Restapro\Services\RecipeResolverService::class);
                $resolver->deductStockForOrder($order);
            } catch (\Throwable $e) {
                Log::error(
                    '[RestaPro] Failed to deduct stock for order: ' . $e->getMessage(),
                    ['order_id' => $order->order_id ?? null, 'trace' => $e->getTraceAsString()]
                );
            }
        });

        // Event Listener: Ripristino stock su ordine annullato
        Event::listen('admin.statusHistory.added', function ($model, $statusHistory) {
            try {
                // Controlla se il modello è un Ordine
                if (class_basename($model) !== 'Order' && class_basename($model) !== 'Orders_model') {
                    return;
                }

                $canceledStatusId = setting('canceled_order_status');
                
                if ($canceledStatusId && $statusHistory->status_id == $canceledStatusId) {
                    Log::info("[RestaPro] Order cancelled event detected for order #{$model->order_id}");
                    $resolver = app(\Paolorox\Restapro\Services\RecipeResolverService::class);
                    $resolver->restoreStockForOrder($model);
                }
            } catch (\Throwable $e) {
                Log::error(
                    '[RestaPro] Failed to restore stock for cancelled order: ' . $e->getMessage(),
                    ['order_id' => $model->order_id ?? null, 'trace' => $e->getTraceAsString()]
                );
            }
        });
    }

    public function registerNavigation(): array
    {
        return [
            'restapro' => [
                'priority' => 400,
                'icon' => 'fa-utensils',
                'title' => lang('paolorox.restapro::default.nav_production'),
                'href' => admin_url('paolorox/restapro/dashboard'),
                'permission' => ['Paolorox.Restapro.*'],
                'child' => [
                    'dashboard' => [
                        'priority' => 100,
                        'title' => lang('paolorox.restapro::default.nav_dashboard'),
                        'href' => admin_url('paolorox/restapro/dashboard'),
                        'permission' => ['Paolorox.Restapro.Dashboard'],
                    ],
                    'ingredients' => [
                        'priority' => 200,
                        'title' => lang('paolorox.restapro::default.nav_ingredients'),
                        'href' => admin_url('paolorox/restapro/ingredients'),
                        'permission' => ['Paolorox.Restapro.ManageIngredients'],
                    ],
                    'recipes' => [
                        'priority' => 300,
                        'title' => lang('paolorox.restapro::default.nav_recipes'),
                        'href' => admin_url('paolorox/restapro/recipes'),
                        'permission' => ['Paolorox.Restapro.ManageRecipes'],
                    ],
                    'suppliers' => [
                        'priority' => 400,
                        'title' => lang('paolorox.restapro::default.nav_suppliers'),
                        'href' => admin_url('paolorox/restapro/suppliers'),
                        'permission' => ['Paolorox.Restapro.ManageSuppliers'],
                    ],
                    'purchaseorders' => [
                        'priority' => 500,
                        'title' => lang('paolorox.restapro::default.nav_purchase_orders'),
                        'href' => admin_url('paolorox/restapro/purchaseorders'),
                        'permission' => ['Paolorox.Restapro.ManagePurchaseOrders'],
                    ],
                    'stockmovements' => [
                        'priority' => 600,
                        'title' => lang('paolorox.restapro::default.nav_stock_movements'),
                        'href' => admin_url('paolorox/restapro/stockmovements'),
                        'permission' => ['Paolorox.Restapro.ViewStockMovements'],
                    ],
                ],
            ],
            'restapro_settings' => [
                'priority' => 401,
                'icon' => 'fa-cogs',
                'title' => lang('paolorox.restapro::default.nav_restapro_settings'),
                'href' => admin_url('paolorox/restapro/categories'),
                'permission' => ['Paolorox.Restapro.*'],
                'child' => [
                    'categories' => [
                        'priority' => 700,
                        'title' => lang('paolorox.restapro::default.nav_categories'),
                        'href' => admin_url('paolorox/restapro/categories'),
                        'permission' => ['Paolorox.Restapro.ManageCategories'],
                    ],
                    'units' => [
                        'priority' => 800,
                        'title' => lang('paolorox.restapro::default.nav_units'),
                        'href' => admin_url('paolorox/restapro/units'),
                        'permission' => ['Paolorox.Restapro.ManageUnits'],
                    ],
                    'info' => [
                        'priority' => 900,
                        'title' => lang('paolorox.restapro::default.nav_info'),
                        'href' => admin_url('paolorox/restapro/info'),
                        'permission' => ['Paolorox.Restapro.ViewInfo'],
                    ],
                    'changelog' => [
                        'priority' => 1000,
                        'title' => lang('paolorox.restapro::default.nav_changelog'),
                        'href' => admin_url('paolorox/restapro/changelog'),
                        'permission' => ['Paolorox.Restapro.Dashboard'],
                    ],
                ],
            ],
        ];
    }

    public function registerPermissions(): array
    {
        return [
            'Paolorox.Restapro.Dashboard' => [
                'group' => lang('paolorox.restapro::default.perm_group'),
                'label' => lang('paolorox.restapro::default.perm_dashboard'),
            ],
            'Paolorox.Restapro.ManageIngredients' => [
                'group' => lang('paolorox.restapro::default.perm_group'),
                'label' => lang('paolorox.restapro::default.perm_ingredients'),
            ],
            'Paolorox.Restapro.ManageRecipes' => [
                'group' => lang('paolorox.restapro::default.perm_group'),
                'label' => lang('paolorox.restapro::default.perm_recipes'),
            ],
            'Paolorox.Restapro.ManageSuppliers' => [
                'group' => lang('paolorox.restapro::default.perm_group'),
                'label' => lang('paolorox.restapro::default.perm_suppliers'),
            ],
            'Paolorox.Restapro.ManagePurchaseOrders' => [
                'group' => lang('paolorox.restapro::default.perm_group'),
                'label' => lang('paolorox.restapro::default.perm_purchaseorders'),
            ],
            'Paolorox.Restapro.ViewStockMovements' => [
                'group' => lang('paolorox.restapro::default.perm_group'),
                'label' => lang('paolorox.restapro::default.perm_stockmovements'),
            ],
            'Paolorox.Restapro.ManageCategories' => [
                'group' => lang('paolorox.restapro::default.perm_group'),
                'label' => lang('paolorox.restapro::default.perm_categories'),
            ],
            'Paolorox.Restapro.ManageUnits' => [
                'group' => lang('paolorox.restapro::default.perm_group'),
                'label' => lang('paolorox.restapro::default.perm_units'),
            ],
            'Paolorox.Restapro.ViewInfo' => [
                'group' => lang('paolorox.restapro::default.perm_group'),
                'label' => lang('paolorox.restapro::default.perm_info'),
            ],
            'Paolorox.Restapro.ManageSettings' => [
                'group' => lang('paolorox.restapro::default.perm_group'),
                'label' => lang('paolorox.restapro::default.perm_settings'),
            ],
        ];
    }

    public function registerSettings(): array
    {
        return [
            'settings' => [
                'label' => 'lang:paolorox.restapro::default.settings_title',
                'description' => 'lang:paolorox.restapro::default.settings_description',
                'icon' => 'fa fa-cogs',
                'model' => \Paolorox\Restapro\Models\Settings::class,
                'permissions' => ['Paolorox.Restapro.ManageSettings'],
            ],
        ];
    }

    public function registerDashboardWidgets(): array
    {
        return [
            \Paolorox\Restapro\DashboardWidgets\RestaProSummary::class => [
                'label' => 'RestaPro Summary',
                'context' => 'dashboard',
                'permissions' => ['Paolorox.Restapro.Dashboard'],
            ],
            \Paolorox\Restapro\DashboardWidgets\ExpiringIngredients::class => [
                'label' => 'Expiring Ingredients',
                'context' => 'dashboard',
                'permissions' => ['Paolorox.Restapro.Dashboard'],
            ],
        ];
    }
}

