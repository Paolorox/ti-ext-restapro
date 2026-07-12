<div class="premium-card p-4 mt-3" style="font-family: 'Inter', sans-serif;">
    <h5 class="section-title mb-4"><i class="fa fa-chart-pie text-primary me-2"></i> Real-Time Margin Analysis</h5>
    @php
        $cost = $formModel->calculated_cost ?? 0;
        $targetCost = $formModel->target_food_cost ?? 30;
        $menuPrice = 0;
        $realPercentage = 0;
        
        if ($formModel->menu) {
            $menuPrice = $formModel->menu->menu_price;
            if ($menuPrice > 0) {
                $realPercentage = ($cost / $menuPrice) * 100;
            }
        }
    @endphp

    @if(!$formModel->menu)
        <div class="alert alert-warning mb-0 border-0 rounded-3 shadow-sm">
            <i class="fa fa-exclamation-triangle me-2"></i> This recipe is not linked to a Menu Item. Link a menu item to calculate the real margin.
        </div>
    @else
        <div class="row align-items-center g-3">
            <div class="col-md-3 text-center">
                <div class="p-3 bg-light rounded-3">
                    <h6 class="text-muted text-uppercase small fw-bold mb-2">Total Ingredient Cost</h6>
                    <h3 class="mb-0 text-dark fw-bold">@lang('paolorox.restapro::default.currency_symbol'){{ number_format($cost, 2) }}</h3>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="p-3 bg-light rounded-3">
                    <h6 class="text-muted text-uppercase small fw-bold mb-2">Menu Selling Price</h6>
                    <h3 class="mb-0 text-dark fw-bold">@lang('paolorox.restapro::default.currency_symbol'){{ number_format($menuPrice, 2) }}</h3>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="p-3 bg-info bg-opacity-10 rounded-3">
                    <h6 class="text-info text-uppercase small fw-bold mb-2">Target Food Cost</h6>
                    <h3 class="mb-0 text-info fw-bold">{{ number_format($targetCost, 2) }}%</h3>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="p-3 bg-{{ $realPercentage > $targetCost ? 'danger' : 'success' }} bg-opacity-10 rounded-3">
                    <h6 class="text-{{ $realPercentage > $targetCost ? 'danger' : 'success' }} text-uppercase small fw-bold mb-2">Real Food Cost</h6>
                    <h3 class="mb-0 text-{{ $realPercentage > $targetCost ? 'danger' : 'success' }} fw-bold">
                        {{ number_format($realPercentage, 2) }}%
                    </h3>
                </div>
            </div>
        </div>
        
        @if($realPercentage > $targetCost)
            <div class="alert alert-danger mt-4 mb-0 border-0 rounded-3 shadow-sm d-flex align-items-center">
                <i class="fa fa-exclamation-circle fa-2x me-3"></i> 
                <div>
                    <strong>Warning!</strong> The real food cost ({{ number_format($realPercentage, 2) }}%) exceeds the target ({{ number_format($targetCost, 2) }}%). You are losing margin.
                </div>
            </div>
        @else
            <div class="alert alert-success mt-4 mb-0 border-0 rounded-3 shadow-sm d-flex align-items-center">
                <i class="fa fa-check-circle fa-2x me-3"></i>
                <div>
                    <strong>Excellent.</strong> The real food cost is within or better than the target margin.
                </div>
            </div>
        @endif
    @endif
</div>

<style>
    .premium-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }
    .section-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.25rem;
    }
</style>
