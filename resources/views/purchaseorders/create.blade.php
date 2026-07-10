{!! form_open([
    'id'     => 'edit-form',
    'role'   => 'form',
    'method' => 'POST',
]) !!}

    {!! $this->renderFormToolbar() !!}

    {!! $this->renderForm([], true) !!}

{!! form_close() !!}
