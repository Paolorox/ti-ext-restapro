<style>
    .premium-table th { font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; color: #64748b; border-bottom: 2px solid #f1f5f9; padding: 1rem; }
    .premium-table td { vertical-align: middle; padding: 1rem; color: #334155; border-bottom: 1px solid #f1f5f9; }
</style>
<div class="table-responsive">
    <table class="table premium-table mb-0">
        <thead class="bg-light">
            <tr>
                <th>@lang('paolorox.restapro::default.stock_movement_date')</th>
                <th>@lang('paolorox.restapro::default.stock_movement_type')</th>
                <th>@lang('paolorox.restapro::default.stock_movement_quantity')</th>
                <th>@lang('paolorox.restapro::default.stock_movement_unit_cost')</th>
                <th>@lang('paolorox.restapro::default.stock_movement_reference')</th>
            </tr>
        </thead>
        <tbody>
            @php
                $movements = \Paolorox\Restapro\Models\StockMovement::where('ingredient_id', $formModel->id)
                    ->orderBy('created_at', 'desc')
                    ->limit(20)
                    ->get();
                
                $chartData = $movements->filter(fn($m) => $m->unit_cost > 0)->reverse();
                $labels = $chartData->map(fn($m) => $m->created_at->format('M d'))->values()->toJson();
                $data = $chartData->map(fn($m) => $m->unit_cost)->values()->toJson();
            @endphp
            
            @if($chartData->count() > 1)
            <div class="mb-4 px-3 pt-3">
                <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 0.5px;">Cost Trend (Unit Cost)</h6>
                <div style="height: 250px; position: relative;">
                    <canvas id="costHistoryChart_{{ $formModel->id }}"></canvas>
                </div>
            </div>
            
            <script>
                (function() {
                    function renderChart() {
                        var canvas = document.getElementById('costHistoryChart_{{ $formModel->id }}');
                        if(!canvas) return;
                        var ctx = canvas.getContext('2d');
                        var gradient = ctx.createLinearGradient(0, 0, 0, 250);
                        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
                        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');
                        
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: {!! $labels !!},
                                datasets: [{
                                    label: 'Unit Cost',
                                    data: {!! $data !!},
                                    borderColor: '#3b82f6',
                                    backgroundColor: gradient,
                                    borderWidth: 2,
                                    pointBackgroundColor: '#ffffff',
                                    pointBorderColor: '#3b82f6',
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    fill: true,
                                    tension: 0.4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { display: false } },
                                scales: {
                                    y: {
                                        beginAtZero: false,
                                        grid: { borderDash: [5, 5], color: '#f1f5f9' },
                                        ticks: {
                                            callback: function(value) { return '{{ lang('paolorox.restapro::default.currency_symbol') }}' + value; }
                                        }
                                    },
                                    x: { grid: { display: false } }
                                }
                            }
                        });
                    }

                    if (typeof Chart === 'undefined') {
                        var script = document.createElement('script');
                        script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
                        script.onload = renderChart;
                        document.head.appendChild(script);
                    } else {
                        renderChart();
                    }
                })();
            </script>
            @endif
            @forelse($movements as $movement)
                <tr>
                    <td class="text-muted small">{{ $movement->created_at->format('d M Y, H:i') }}</td>
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
                        <span class="badge {{ $badgeClass }} px-2 py-1">
                            {{ ucfirst($movement->type) }}
                        </span>
                    </td>
                    <td class="fw-bold {{ $movement->quantity > 0 ? 'text-success' : 'text-danger' }}">
                        {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                    </td>
                    <td class="fw-semibold">@lang('paolorox.restapro::default.currency_symbol'){{ number_format($movement->unit_cost, 2) }}</td>
                    <td><span class="text-muted">{{ $movement->reference_id ?? '—' }}</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="fa fa-folder-open fa-2x mb-2 text-light"></i>
                        <div>No movements found.</div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3 text-end px-3 pb-3">
        <a href="{{ admin_url('paolorox/restapro/stockmovements') }}" class="btn btn-outline-primary rounded-pill px-4">View All</a>
    </div>
</div>
