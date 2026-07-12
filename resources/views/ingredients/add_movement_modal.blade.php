<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">@lang('paolorox.restapro::default.button_add_movement')</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <form method="POST" accept-charset="UTF-8" data-request="onAddMovement" data-request-success="jQuery('[data-dismiss=modal]').trigger('click');">
            <div class="modal-body">
                <div class="form-group">
                    <label>@lang('paolorox.restapro::default.stock_movement_ingredient')</label>
                    <select name="ingredient_id" class="form-select" required>
                        <option value="">@lang('admin::lang.text_select')</option>
                        @foreach ($ingredients as $ingredient)
                            <option value="{{ $ingredient->id }}">{{ $ingredient->name }} (Stock: {{ $ingredient->stock }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label>@lang('paolorox.restapro::default.stock_movement_type')</label>
                    <select name="type" class="form-select" required>
                        <option value="waste">@lang('paolorox.restapro::default.stock_movement_type_waste')</option>
                        <option value="adjustment">@lang('paolorox.restapro::default.stock_movement_type_adjustment')</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>@lang('paolorox.restapro::default.stock_movement_quantity')</label>
                    <input type="number" step="0.001" name="quantity" class="form-control" required />
                    <small class="help-block">@lang('paolorox.restapro::default.help_movement_quantity')</small>
                </div>
                
                <div class="form-group">
                    <label>@lang('paolorox.restapro::default.stock_movement_notes')</label>
                    <textarea name="notes" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">@lang('admin::lang.button_cancel')</button>
                <button type="submit" class="btn btn-primary">@lang('admin::lang.button_save')</button>
            </div>
        </form>
    </div>
</div>
