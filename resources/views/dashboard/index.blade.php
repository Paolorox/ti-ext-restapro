<div class="container-fluid py-3">
    <style>
        .card-hover { transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }
    </style>
    {{-- KPI Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <a href="{{ admin_url('paolorox/restapro/ingredients') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded-3 p-3">
                                <i class="fa fa-leaf fa-2x text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">@lang('paolorox.restapro::default.dashboard_active_ingredients')</h6>
                                <h3 class="mb-0 text-dark">{{ $totalIngredients }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="{{ admin_url('paolorox/restapro/recipes') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-success bg-opacity-10 rounded-3 p-3">
                                <i class="fa fa-utensils fa-2x text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">@lang('paolorox.restapro::default.dashboard_active_recipes')</h6>
                                <h3 class="mb-0 text-dark">{{ $totalRecipes }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="{{ admin_url('paolorox/restapro/stockmovements') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-info bg-opacity-10 rounded-3 p-3">
                                <i class="fa fa-warehouse fa-2x text-info"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">@lang('paolorox.restapro::default.dashboard_inventory_value')</h6>
                                <h3 class="mb-0 text-dark">@lang('paolorox.restapro::default.currency_symbol'){{ number_format($totalInventoryValue, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="{{ admin_url('paolorox/restapro/ingredients') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-danger bg-opacity-10 rounded-3 p-3">
                                <i class="fa fa-exclamation-triangle fa-2x text-danger"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">@lang('paolorox.restapro::default.dashboard_low_stock_alerts')</h6>
                                <h3 class="mb-0 {{ $lowStockCount > 0 ? 'text-danger' : 'text-dark' }}">{{ $lowStockCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-3">
        {{-- Low Stock Alert Table --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-exclamation-circle text-warning me-2"></i>@lang('paolorox.restapro::default.dashboard_low_stock_title')
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>@lang('paolorox.restapro::default.recipe_ingredient_ingredient')</th>
                                    <th>@lang('paolorox.restapro::default.ingredient_stock')</th>
                                    <th>@lang('paolorox.restapro::default.ingredient_minimum_stock')</th>
                                    <th>@lang('paolorox.restapro::default.ingredient_supplier')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockIngredients as $ingredient)
                                    <tr>
                                        <td>
                                            <a href="{{ admin_url('paolorox/restapro/ingredients/edit/'.$ingredient->id) }}">
                                                {{ $ingredient->name }}
                                            </a>
                                        </td>
                                        <td class="text-danger fw-bold">
                                            {{ number_format((float)$ingredient->stock, 3) }} {{ $ingredient->unit->abbreviation ?? '' }}
                                        </td>
                                        <td>{{ number_format((float)$ingredient->minimum_stock, 3) }} {{ $ingredient->unit->abbreviation ?? '' }}</td>
                                        <td>{{ $ingredient->supplier->name ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">
                                            <i class="fa fa-check-circle text-success me-1"></i> @lang('paolorox.restapro::default.dashboard_all_stocks_ok')
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Over-Target Food Cost --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-chart-line text-danger me-2"></i>@lang('paolorox.restapro::default.dashboard_over_target_title')
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>@lang('paolorox.restapro::default.recipe_name')</th>
                                    <th>@lang('paolorox.restapro::default.dashboard_actual_fc')</th>
                                    <th>@lang('paolorox.restapro::default.recipe_target_food_cost')</th>
                                    <th>@lang('paolorox.restapro::default.dashboard_menu_price')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($overTargetRecipes as $recipe)
                                    <tr>
                                        <td>
                                            <a href="{{ admin_url('paolorox/restapro/recipes/edit/'.$recipe->id) }}">
                                                {{ $recipe->name }}
                                            </a>
                                        </td>
                                        <td class="text-danger fw-bold">{{ number_format((float)$recipe->actual_food_cost_percent, 1) }}%</td>
                                        <td>{{ number_format((float)$recipe->target_food_cost, 1) }}%</td>
                                        <td>@lang('paolorox.restapro::default.currency_symbol'){{ number_format((float)($recipe->menu->menu_price ?? 0), 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">
                                            <i class="fa fa-check-circle text-success me-1"></i> @lang('paolorox.restapro::default.dashboard_all_recipes_ok')
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Movements --}}
    <div class="row g-3 mt-1">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-exchange-alt text-primary me-2"></i>@lang('paolorox.restapro::default.dashboard_recent_movements')
                    </h5>
                    <a href="{{ admin_url('paolorox/restapro/stockmovements') }}" class="btn btn-sm btn-outline-primary">
                        @lang('paolorox.restapro::default.dashboard_view_all')
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>@lang('paolorox.restapro::default.stock_movement_date')</th>
                                    <th>@lang('paolorox.restapro::default.stock_movement_ingredient')</th>
                                    <th>@lang('paolorox.restapro::default.stock_movement_type')</th>
                                    <th>@lang('paolorox.restapro::default.stock_movement_quantity')</th>
                                    <th>@lang('paolorox.restapro::default.stock_movement_unit_cost')</th>
                                    <th>@lang('paolorox.restapro::default.stock_movement_reference')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentMovements as $movement)
                                    <tr>
                                        <td>{{ $movement->created_at?->format('d/m/Y H:i') ?? '—' }}</td>
                                        <td>{{ $movement->ingredient->name ?? '—' }}</td>
                                        <td>
                                            @php
                                                $badgeClass = match($movement->type) {
                                                    'purchase' => 'bg-success',
                                                    'sale' => 'bg-primary',
                                                    'waste' => 'bg-warning',
                                                    'adjustment' => 'bg-info',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $movement->type_name }}</span>
                                        </td>
                                        <td class="{{ $movement->quantity < 0 ? 'text-danger' : 'text-success' }}">
                                            {{ $movement->quantity > 0 ? '+' : '' }}{{ number_format((float)$movement->quantity, 3) }}
                                        </td>
                                        <td>@lang('paolorox.restapro::default.currency_symbol'){{ number_format((float)$movement->unit_cost, 4) }}</td>
                                        <td>{{ $movement->reference_id ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
