{!! $this->makePartial('paolorox.restapro::partials/settings_tabs') !!}

{!! form_open([
    'id'     => 'edit-form',
    'role'   => 'form',
    'method' => 'POST',
]) !!}

    {!! $this->renderFormToolbar() !!}

    {!! $this->renderForm([], true) !!}

{!! form_close() !!}
