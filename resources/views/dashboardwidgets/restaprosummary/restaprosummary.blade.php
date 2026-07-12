<div class="dashboard-widget">
    <h6 class="widget-title"><i class="fa fa-cutlery text-muted"></i> RestaPro Summary</h6>
    
    <div class="row pt-3">
        <div class="col-6 col-md-3 text-center">
            <h3 class="{{ $lowStockCount > 0 ? 'text-danger' : 'text-success' }} mb-1">
                {{ $lowStockCount }}
            </h3>
            <p class="text-muted small">Low Stock Items</p>
        </div>
        <div class="col-6 col-md-3 text-center">
            <h3 class="{{ $expiredCount > 0 ? 'text-danger' : 'text-success' }} mb-1">
                {{ $expiredCount }}
            </h3>
            <p class="text-muted small">Expired Items</p>
        </div>
        <div class="col-6 col-md-3 text-center mt-3 mt-md-0">
            <h3 class="{{ $expiringSoonCount > 0 ? 'text-warning' : 'text-success' }} mb-1">
                {{ $expiringSoonCount }}
            </h3>
            <p class="text-muted small">Expiring Soon</p>
        </div>
        <div class="col-6 col-md-3 text-center mt-3 mt-md-0">
            <h3 class="text-info mb-1">
                {{ $pendingOrdersCount }}
            </h3>
            <p class="text-muted small">Active Orders</p>
        </div>
    </div>

    <div class="text-center mt-3">
        <a href="{{ admin_url('paolorox/restapro/dashboard') }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-external-link"></i> Go to Dashboard
        </a>
    </div>
</div>
