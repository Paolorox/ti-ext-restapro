<div class="container-fluid py-4" style="background-color: #f8f9fa;">
    <style>
        /* Modern Typography */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        .restapro-dashboard {
            font-family: 'Inter', sans-serif;
        }

        /* Glassmorphism & Cards */
        .premium-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
            position: relative;
        }
        
        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        }

        /* Vibrant Gradients for Icons */
        .icon-shape {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .bg-gradient-primary { background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); }
        .bg-gradient-success { background: linear-gradient(135deg, #10b981 0%, #34d399 100%); }
        .bg-gradient-info { background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%); }
        .bg-gradient-danger { background: linear-gradient(135deg, #ef4444 0%, #f87171 100%); }
        .bg-gradient-warning { background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); }
        
        /* Table Styling */
        .premium-table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 2px solid #f1f5f9;
            padding: 1rem;
        }
        .premium-table td {
            vertical-align: middle;
            padding: 1rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }
        .premium-table tr:last-child td { border-bottom: none; }
        
        /* Headers */
        .section-title {
            font-weight: 700;
            color: #1e293b;
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* Value styling */
        .value-lg {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.5px;
        }
        .value-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Decorative Background */
        .card-decorator {
            position: absolute;
            top: -20px;
            right: -20px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            opacity: 0.1;
            z-index: 0;
        }
    </style>

    <div class="restapro-dashboard">
        
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold text-dark mb-0">RestaPro <span class="text-primary">Analytics</span></h2>
                <p class="text-muted mb-0">Real-time inventory and food cost intelligence.</p>
            </div>
            <div>
                <a href="{{ admin_url('paolorox/restapro/stockmovements') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                    <i class="fa fa-plus me-2"></i>New Movement
                </a>
            </div>
        </div>

        <!-- Row 1: Main KPIs -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-sm-6">
                <a href="{{ admin_url('paolorox/restapro/ingredients') }}" class="text-decoration-none">
                    <div class="premium-card p-4 h-100">
                        <div class="card-decorator bg-gradient-primary"></div>
                        <div class="d-flex align-items-center position-relative z-index-1">
                            <div class="icon-shape bg-gradient-primary">
                                <i class="fa fa-leaf"></i>
                            </div>
                            <div class="ms-3">
                                <div class="value-label">Active Ingredients</div>
                                <div class="value-lg">{{ $totalIngredients }}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6">
                <a href="{{ admin_url('paolorox/restapro/recipes') }}" class="text-decoration-none">
                    <div class="premium-card p-4 h-100">
                        <div class="card-decorator bg-gradient-success"></div>
                        <div class="d-flex align-items-center position-relative z-index-1">
                            <div class="icon-shape bg-gradient-success">
                                <i class="fa fa-utensils"></i>
                            </div>
                            <div class="ms-3">
                                <div class="value-label">Active Recipes</div>
                                <div class="value-lg">{{ $totalRecipes }}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6">
                <a href="{{ admin_url('paolorox/restapro/stockmovements') }}" class="text-decoration-none">
                    <div class="premium-card p-4 h-100">
                        <div class="card-decorator bg-gradient-info"></div>
                        <div class="d-flex align-items-center position-relative z-index-1">
                            <div class="icon-shape bg-gradient-info">
                                <i class="fa fa-warehouse"></i>
                            </div>
                            <div class="ms-3">
                                <div class="value-label">Inventory Value</div>
                                <div class="value-lg">@lang('paolorox.restapro::default.currency_symbol'){{ number_format($totalInventoryValue, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6">
                <a href="{{ admin_url('paolorox/restapro/ingredients') }}" class="text-decoration-none">
                    <div class="premium-card p-4 h-100 border-{{ $lowStockCount > 0 ? 'danger' : 'light' }}">
                        <div class="card-decorator bg-gradient-danger"></div>
                        <div class="d-flex align-items-center position-relative z-index-1">
                            <div class="icon-shape bg-gradient-danger">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                            <div class="ms-3">
                                <div class="value-label text-danger">Low Stock Alerts</div>
                                <div class="value-lg text-danger">{{ $lowStockCount }}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Row 2: Expiry Alerts & Margin Warnings -->
        <div class="row g-4 mb-4">
            <!-- Expiry Alerts -->
            <div class="col-lg-6">
                <div class="premium-card p-4 h-100">
                    <h4 class="section-title"><i class="fa fa-calendar-times text-warning"></i> Expiry Radar</h4>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 bg-danger bg-opacity-10 rounded-3 text-center">
                                <h2 class="text-danger fw-bold mb-0">{{ $expiredCount }}</h2>
                                <span class="text-danger small fw-semibold text-uppercase">Expired</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-warning bg-opacity-10 rounded-3 text-center">
                                <h2 class="text-warning fw-bold mb-0">{{ $expiringSoonCount }}</h2>
                                <span class="text-warning small fw-semibold text-uppercase">Expiring Soon</span>
                            </div>
                        </div>
                    </div>
                    @if($expiredCount > 0 || $expiringSoonCount > 0)
                        <div class="mt-3 table-responsive">
                            <table class="table premium-table mb-0">
                                <tbody>
                                    @foreach($expiredIngredients->take(3) as $ing)
                                        <tr>
                                            <td class="py-2 px-0"><a href="{{ admin_url('paolorox/restapro/ingredients/edit/'.$ing->id) }}" class="text-dark fw-bold text-decoration-none">{{ $ing->name }}</a></td>
                                            <td class="py-2 px-0 text-end"><span class="badge bg-danger">Expired {{ \Carbon\Carbon::parse($ing->expiry_date)->diffForHumans() }}</span></td>
                                        </tr>
                                    @endforeach
                                    @foreach($expiringSoonIngredients->take(3) as $ing)
                                        <tr>
                                            <td class="py-2 px-0"><a href="{{ admin_url('paolorox/restapro/ingredients/edit/'.$ing->id) }}" class="text-dark fw-bold text-decoration-none">{{ $ing->name }}</a></td>
                                            <td class="py-2 px-0 text-end"><span class="badge bg-warning text-dark">Expiring {{ \Carbon\Carbon::parse($ing->expiry_date)->diffForHumans() }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ admin_url('paolorox/restapro/ingredients') }}" class="btn btn-sm btn-outline-dark rounded-pill">Manage All Expirations <i class="fa fa-arrow-right ms-1"></i></a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Over-Target Food Cost -->
            <div class="col-lg-6">
                <div class="premium-card p-4 h-100">
                    <h4 class="section-title"><i class="fa fa-chart-line text-danger"></i> Profitability Warnings</h4>
                    <div class="table-responsive">
                        <table class="table premium-table mb-0">
                            <thead>
                                <tr>
                                    <th>Recipe</th>
                                    <th>Actual %</th>
                                    <th>Target %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($overTargetRecipes->take(3) as $recipe)
                                    <tr>
                                        <td class="fw-semibold">
                                            <a href="{{ admin_url('paolorox/restapro/recipes/edit/'.$recipe->id) }}" class="text-dark text-decoration-none">
                                                {{ $recipe->name }}
                                            </a>
                                        </td>
                                        <td><span class="badge bg-danger rounded-pill px-3 py-2">{{ number_format((float)$recipe->actual_food_cost_percent, 1) }}%</span></td>
                                        <td class="text-muted">{{ number_format((float)$recipe->target_food_cost, 1) }}%</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <div class="text-success"><i class="fa fa-check-circle fa-2x mb-2"></i></div>
                                            <div class="fw-semibold">All recipes are profitable!</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 3: Tables -->
        <div class="row g-4">
            <!-- Low Stock Table -->
            <div class="col-lg-6">
                <div class="premium-card p-0 h-100">
                    <div class="p-4 border-bottom">
                        <h4 class="section-title mb-0"><i class="fa fa-box-open text-primary"></i> Restock Needed</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table premium-table mb-0">
                            <thead>
                                <tr>
                                    <th>Ingredient</th>
                                    <th>Current</th>
                                    <th>Min</th>
                                    <th>Supplier</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockIngredients->take(5) as $ingredient)
                                    <tr>
                                        <td class="fw-semibold">
                                            <a href="{{ admin_url('paolorox/restapro/ingredients/edit/'.$ingredient->id) }}" class="text-dark text-decoration-none">
                                                {{ $ingredient->name }}
                                            </a>
                                        </td>
                                        <td class="text-danger fw-bold">
                                            {{ number_format((float)$ingredient->stock, 2) }} {{ $ingredient->unit->abbreviation ?? '' }}
                                        </td>
                                        <td class="text-muted">{{ number_format((float)$ingredient->minimum_stock, 2) }}</td>
                                        <td><span class="badge bg-light text-dark">{{ $ingredient->supplier->name ?? '—' }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="text-success"><i class="fa fa-check-circle fa-2x mb-2"></i></div>
                                            <div class="fw-semibold">Inventory levels are optimal</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Movements -->
            <div class="col-lg-6">
                <div class="premium-card p-0 h-100">
                    <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                        <h4 class="section-title mb-0"><i class="fa fa-exchange-alt text-info"></i> Recent Activity</h4>
                        <a href="{{ admin_url('paolorox/restapro/stockmovements') }}" class="btn btn-sm btn-light rounded-pill">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table premium-table mb-0">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Type</th>
                                    <th>Qty</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentMovements->take(5) as $movement)
                                    <tr>
                                        <td class="fw-semibold">{{ $movement->ingredient->name ?? '—' }}</td>
                                        <td>
                                            @php
                                                $badgeClass = match($movement->type) {
                                                    'purchase' => 'bg-success bg-opacity-10 text-success',
                                                    'sale' => 'bg-primary bg-opacity-10 text-primary',
                                                    'waste' => 'bg-warning bg-opacity-10 text-warning',
                                                    'adjustment' => 'bg-info bg-opacity-10 text-info',
                                                    default => 'bg-secondary bg-opacity-10 text-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} px-2 py-1">{{ $movement->type_name }}</span>
                                        </td>
                                        <td class="fw-bold {{ $movement->quantity > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $movement->quantity > 0 ? '+' : '' }}{{ number_format((float)$movement->quantity, 2) }}
                                        </td>
                                        <td class="text-muted small">{{ $movement->created_at?->diffForHumans() ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">No recent activity</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Row 3: Low Stock Details -->
        @if($lowStockCount > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="premium-card p-4">
                    <h4 class="section-title mb-4"><i class="fa fa-exclamation-triangle text-danger"></i> Low Stock Alerts Details</h4>
                    <div class="table-responsive">
                        <table class="table premium-table mb-0">
                            <thead>
                                <tr>
                                    <th>Ingredient</th>
                                    <th>Current Stock</th>
                                    <th>Threshold</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockIngredients->take(5) as $ing)
                                    <tr>
                                        <td><a href="{{ admin_url('paolorox/restapro/ingredients/edit/'.$ing->id) }}" class="text-dark fw-bold text-decoration-none">{{ $ing->name }}</a></td>
                                        <td><span class="text-danger fw-bold">{{ number_format($ing->stock, 2) }} {{ $ing->unit ? $ing->unit->abbreviation : '' }}</span></td>
                                        <td class="text-muted">{{ number_format($ing->minimum_stock, 2) }} {{ $ing->unit ? $ing->unit->abbreviation : '' }}</td>
                                        <td><a href="{{ admin_url('paolorox/restapro/stockmovements/create') }}" class="btn btn-sm btn-outline-primary rounded-pill">Restock</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
