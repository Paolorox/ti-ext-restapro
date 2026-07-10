{!! form_open([
    'id'     => 'edit-form',
    'role'   => 'form',
    'method' => 'PATCH',
]) !!}

    {!! $this->renderFormToolbar() !!}

    {!! $this->renderForm([], true) !!}

{!! form_close() !!}
