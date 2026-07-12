<div class="dashboard-widget widget-expiring-ingredients">
    <h6 class="widget-title">@lang($this->property('title'))</h6>

    <div class="row">
        @if(count($expired) > 0)
        <div class="col-12 mb-3">
            <div class="alert alert-danger mb-0">
                <h5 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> @lang('paolorox.restapro::default.widget_expired_title')</h5>
                <ul class="mb-0">
                    @foreach($expired as $ingredient)
                        <li>
                            <strong><a href="{{ admin_url('paolorox/restapro/ingredients/edit/'.$ingredient->id) }}" class="text-danger">{{ $ingredient->name }}</a></strong> 
                            (Stock: {{ $ingredient->stockDisplay }}) - 
                            <em>Scaduto il {{ $ingredient->expiry_date->format('d/m/Y') }}</em>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="col-12">
            @if(count($expiringSoon) > 0)
                <ul class="list-group list-group-flush">
                    @foreach($expiringSoon as $ingredient)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong><a href="{{ admin_url('paolorox/restapro/ingredients/edit/'.$ingredient->id) }}">{{ $ingredient->name }}</a></strong><br>
                                <small class="text-muted">Stock: {{ $ingredient->stockDisplay }}</small>
                            </div>
                            <span class="badge bg-warning rounded-pill">
                                Scade il {{ $ingredient->expiry_date->format('d/m/Y') }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                @if(count($expired) == 0)
                <p class="text-muted text-center my-3">
                    @lang('paolorox.restapro::default.widget_no_expiring')
                </p>
                @endif
            @endif
        </div>
    </div>
</div>
