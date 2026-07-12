{!! $this->makePartial('paolorox.restapro::partials/settings_tabs') !!}

<div class="row-fluid">
    {!! form_open(current_url(),
        [
            'id' => 'form-widget',
            'role' => 'form',
            'method' => 'PATCH',
        ]
    ) !!}

    {!! $this->renderFormToolbar() !!}

    {!! $this->renderForm([], true) !!}

{!! form_close() !!}
</div>
