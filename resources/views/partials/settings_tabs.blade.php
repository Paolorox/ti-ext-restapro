@php
    $url = request()->url();
    $activeTab = 'settings';
    if (strpos($url, 'categories') !== false) $activeTab = 'categories';
    elseif (strpos($url, 'units') !== false) $activeTab = 'units';
    elseif (strpos($url, 'info') !== false) $activeTab = 'info';
    elseif (strpos($url, 'changelog') !== false) $activeTab = 'changelog';
@endphp

<div class="mb-4">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'settings' ? 'active fw-bold' : '' }}" href="{{ admin_url('settings/edit/paolorox_restapro_settings') }}">
                <i class="fa fa-cogs me-1"></i> General Settings
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'categories' ? 'active fw-bold' : '' }}" href="{{ admin_url('paolorox/restapro/categories') }}">
                <i class="fa fa-tags me-1"></i> Categories
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'units' ? 'active fw-bold' : '' }}" href="{{ admin_url('paolorox/restapro/units') }}">
                <i class="fa fa-balance-scale me-1"></i> Units
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'info' ? 'active fw-bold' : '' }}" href="{{ admin_url('paolorox/restapro/info') }}">
                <i class="fa fa-info-circle me-1"></i> Info & Guide
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'changelog' ? 'active fw-bold' : '' }}" href="{{ admin_url('paolorox/restapro/changelog') }}">
                <i class="fa fa-history me-1"></i> Changelog
            </a>
        </li>
    </ul>
</div>
