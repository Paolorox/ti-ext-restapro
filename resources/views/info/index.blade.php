{!! $this->makePartial('paolorox.restapro::partials/settings_tabs') !!}

<div class="container-fluid py-3">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-2">
                <div class="flex-shrink-0 bg-success bg-opacity-10 rounded-3 p-3 me-3">
                    <i class="fa fa-industry fa-2x text-success"></i>
                </div>
                <div class="flex-grow-1">
                    <h2 class="mb-1">Restaurant Production Pro</h2>
                    <p class="text-muted mb-0">@lang('paolorox.restapro::default.info_subtitle')</p>
                </div>
                <div>
                    <button class="btn btn-primary" onclick="localStorage.removeItem('restapro_tour_completed'); window.location.href='{{ admin_url('paolorox/restapro/dashboard') }}';">
                        <i class="fa fa-play-circle me-1"></i> Restart Tutorial
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Extension Info & System Status Cards --}}
    <div class="row g-3 mb-4">
        {{-- Extension Info Card --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-info-circle text-primary me-2"></i>@lang('paolorox.restapro::default.info_title')
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted fw-semibold" style="width:45%">@lang('paolorox.restapro::default.info_version')</td>
                            <td><span class="badge bg-success">{{ $extensionVersion }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">@lang('paolorox.restapro::default.info_author')</td>
                            <td>{{ $extensionAuthor }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">@lang('paolorox.restapro::default.info_license')</td>
                            <td>{{ $extensionLicense }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">@lang('paolorox.restapro::default.info_homepage')</td>
                            <td><a href="{{ $extensionHomepage }}" target="_blank" rel="noopener">GitHub <i class="fa fa-external-link-alt fa-xs"></i></a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- System Status Card --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-chart-bar text-info me-2"></i>@lang('paolorox.restapro::default.info_system_status')
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted fw-semibold" style="width:60%">@lang('paolorox.restapro::default.info_total_ingredients')</td>
                            <td class="text-end"><span class="badge bg-primary rounded-pill">{{ $totalIngredients }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">@lang('paolorox.restapro::default.info_total_recipes')</td>
                            <td class="text-end"><span class="badge bg-primary rounded-pill">{{ $totalRecipes }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">@lang('paolorox.restapro::default.info_total_suppliers')</td>
                            <td class="text-end"><span class="badge bg-primary rounded-pill">{{ $totalSuppliers }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">@lang('paolorox.restapro::default.info_total_categories')</td>
                            <td class="text-end"><span class="badge bg-primary rounded-pill">{{ $totalCategories }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">@lang('paolorox.restapro::default.info_total_units')</td>
                            <td class="text-end"><span class="badge bg-primary rounded-pill">{{ $totalUnits }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">@lang('paolorox.restapro::default.info_total_purchase_orders')</td>
                            <td class="text-end"><span class="badge bg-primary rounded-pill">{{ $totalPurchaseOrders }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold">@lang('paolorox.restapro::default.info_total_stock_movements')</td>
                            <td class="text-end"><span class="badge bg-primary rounded-pill">{{ $totalStockMovements }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Database Health Card --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-database {{ $dbOk ? 'text-success' : 'text-danger' }} me-2"></i>@lang('paolorox.restapro::default.info_db_status')
                    </h5>
                </div>
                <div class="card-body">
                    @if($dbOk)
                        <div class="alert alert-success d-flex align-items-center mb-3" role="alert">
                            <i class="fa fa-check-circle me-2"></i>
                            <div>@lang('paolorox.restapro::default.info_db_ok')</div>
                        </div>
                    @else
                        <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
                            <i class="fa fa-exclamation-triangle me-2"></i>
                            <div>@lang('paolorox.restapro::default.info_db_error')</div>
                        </div>
                    @endif
                    <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                        <table class="table table-sm mb-0">
                            @foreach($requiredTables as $table)
                                <tr>
                                    <td>
                                        @if(in_array($table, $missingTables))
                                            <i class="fa fa-times-circle text-danger me-1"></i>
                                        @else
                                            <i class="fa fa-check-circle text-success me-1"></i>
                                        @endif
                                        <code>{{ $table }}</code>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Start Guide --}}
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-rocket text-success me-2"></i>@lang('paolorox.restapro::default.guide_quickstart_title')
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <span class="badge bg-success rounded-pill me-3 mt-1" style="min-width:28px">1</span>
                                <div>@lang('paolorox.restapro::default.guide_quickstart_step1')</div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <span class="badge bg-success rounded-pill me-3 mt-1" style="min-width:28px">2</span>
                                <div>@lang('paolorox.restapro::default.guide_quickstart_step2')</div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <span class="badge bg-success rounded-pill me-3 mt-1" style="min-width:28px">3</span>
                                <div>@lang('paolorox.restapro::default.guide_quickstart_step3')</div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <span class="badge bg-success rounded-pill me-3 mt-1" style="min-width:28px">4</span>
                                <div>@lang('paolorox.restapro::default.guide_quickstart_step4')</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <span class="badge bg-success rounded-pill me-3 mt-1" style="min-width:28px">5</span>
                                <div>@lang('paolorox.restapro::default.guide_quickstart_step5')</div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <span class="badge bg-success rounded-pill me-3 mt-1" style="min-width:28px">6</span>
                                <div>@lang('paolorox.restapro::default.guide_quickstart_step6')</div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <span class="badge bg-success rounded-pill me-3 mt-1" style="min-width:28px">7</span>
                                <div>@lang('paolorox.restapro::default.guide_quickstart_step7')</div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <span class="badge bg-success rounded-pill me-3 mt-1" style="min-width:28px">8</span>
                                <div>@lang('paolorox.restapro::default.guide_quickstart_step8')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detailed Module Guides --}}
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="accordion" id="restapro-guide-accordion">

                {{-- Overview --}}
                <div class="accordion-item border-0 shadow-sm mb-2 rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#guide-overview">
                            <i class="fa fa-industry text-success me-2"></i>
                            @lang('paolorox.restapro::default.guide_overview_title')
                        </button>
                    </h2>
                    <div id="guide-overview" class="accordion-collapse collapse show" data-bs-parent="#restapro-guide-accordion">
                        <div class="accordion-body">
                            <p class="mb-0">@lang('paolorox.restapro::default.guide_overview_text')</p>
                        </div>
                    </div>
                </div>

                {{-- Ingredients --}}
                <div class="accordion-item border-0 shadow-sm mb-2 rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#guide-ingredients">
                            <i class="fa fa-leaf text-primary me-2"></i>
                            @lang('paolorox.restapro::default.guide_ingredients_title')
                        </button>
                    </h2>
                    <div id="guide-ingredients" class="accordion-collapse collapse" data-bs-parent="#restapro-guide-accordion">
                        <div class="accordion-body">
                            <p class="mb-0">@lang('paolorox.restapro::default.guide_ingredients_text')</p>
                        </div>
                    </div>
                </div>

                {{-- Recipes --}}
                <div class="accordion-item border-0 shadow-sm mb-2 rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#guide-recipes">
                            <i class="fa fa-utensils text-warning me-2"></i>
                            @lang('paolorox.restapro::default.guide_recipes_title')
                        </button>
                    </h2>
                    <div id="guide-recipes" class="accordion-collapse collapse" data-bs-parent="#restapro-guide-accordion">
                        <div class="accordion-body">
                            <p class="mb-0">@lang('paolorox.restapro::default.guide_recipes_text')</p>
                        </div>
                    </div>
                </div>

                {{-- Suppliers --}}
                <div class="accordion-item border-0 shadow-sm mb-2 rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#guide-suppliers">
                            <i class="fa fa-truck text-info me-2"></i>
                            @lang('paolorox.restapro::default.guide_suppliers_title')
                        </button>
                    </h2>
                    <div id="guide-suppliers" class="accordion-collapse collapse" data-bs-parent="#restapro-guide-accordion">
                        <div class="accordion-body">
                            <p class="mb-0">@lang('paolorox.restapro::default.guide_suppliers_text')</p>
                        </div>
                    </div>
                </div>

                {{-- Purchase Orders --}}
                <div class="accordion-item border-0 shadow-sm mb-2 rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#guide-purchase-orders">
                            <i class="fa fa-clipboard-list text-danger me-2"></i>
                            @lang('paolorox.restapro::default.guide_purchase_orders_title')
                        </button>
                    </h2>
                    <div id="guide-purchase-orders" class="accordion-collapse collapse" data-bs-parent="#restapro-guide-accordion">
                        <div class="accordion-body">
                            <p class="mb-0">@lang('paolorox.restapro::default.guide_purchase_orders_text')</p>
                        </div>
                    </div>
                </div>

                {{-- Stock Movements --}}
                <div class="accordion-item border-0 shadow-sm mb-2 rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#guide-stock-movements">
                            <i class="fa fa-exchange-alt text-secondary me-2"></i>
                            @lang('paolorox.restapro::default.guide_stock_movements_title')
                        </button>
                    </h2>
                    <div id="guide-stock-movements" class="accordion-collapse collapse" data-bs-parent="#restapro-guide-accordion">
                        <div class="accordion-body">
                            <p class="mb-0">@lang('paolorox.restapro::default.guide_stock_movements_text')</p>
                        </div>
                    </div>
                </div>

                {{-- Units --}}
                <div class="accordion-item border-0 shadow-sm mb-2 rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#guide-units">
                            <i class="fa fa-ruler-combined text-dark me-2"></i>
                            @lang('paolorox.restapro::default.guide_units_title')
                        </button>
                    </h2>
                    <div id="guide-units" class="accordion-collapse collapse" data-bs-parent="#restapro-guide-accordion">
                        <div class="accordion-body">
                            <p class="mb-0">@lang('paolorox.restapro::default.guide_units_text')</p>
                        </div>
                    </div>
                </div>

                {{-- Categories --}}
                <div class="accordion-item border-0 shadow-sm mb-2 rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#guide-categories">
                            <i class="fa fa-tags text-purple me-2" style="color:#7c3aed"></i>
                            @lang('paolorox.restapro::default.guide_categories_title')
                        </button>
                    </h2>
                    <div id="guide-categories" class="accordion-collapse collapse" data-bs-parent="#restapro-guide-accordion">
                        <div class="accordion-body">
                            <p class="mb-0">@lang('paolorox.restapro::default.guide_categories_text')</p>
                        </div>
                    </div>
                </div>

                {{-- Automation --}}
                <div class="accordion-item border-0 shadow-sm mb-2 rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#guide-automation">
                            <i class="fa fa-bolt text-warning me-2"></i>
                            @lang('paolorox.restapro::default.guide_automation_title')
                        </button>
                    </h2>
                    <div id="guide-automation" class="accordion-collapse collapse" data-bs-parent="#restapro-guide-accordion">
                        <div class="accordion-body">
                            <p class="mb-0">@lang('paolorox.restapro::default.guide_automation_text')</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Pro Tips --}}
    <div class="row g-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-lightbulb text-warning me-2"></i>@lang('paolorox.restapro::default.guide_tips_title')
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <i class="fa fa-check text-success me-2 mt-1"></i>
                                <div>@lang('paolorox.restapro::default.guide_tip_1')</div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <i class="fa fa-check text-success me-2 mt-1"></i>
                                <div>@lang('paolorox.restapro::default.guide_tip_2')</div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <i class="fa fa-check text-success me-2 mt-1"></i>
                                <div>@lang('paolorox.restapro::default.guide_tip_3')</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <i class="fa fa-check text-success me-2 mt-1"></i>
                                <div>@lang('paolorox.restapro::default.guide_tip_4')</div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <i class="fa fa-check text-success me-2 mt-1"></i>
                                <div>@lang('paolorox.restapro::default.guide_tip_5')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
