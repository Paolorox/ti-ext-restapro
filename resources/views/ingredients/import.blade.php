<div class="row-fluid">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-upload"></i> Import Ingredients from CSV</h3>
            </div>
            <div class="panel-body">
                <p>Upload a CSV file to bulk import ingredients. The CSV should have the following headers:</p>
                <ul>
                    <li><code>Name</code> (Required)</li>
                    <li><code>SKU</code></li>
                    <li><code>Category</code> (Name of the category)</li>
                    <li><code>Unit</code> (Abbreviation of the unit, e.g. kg, L, pcs)</li>
                    <li><code>Low Stock Threshold</code></li>
                    <li><code>Is Active</code> (1 or 0)</li>
                </ul>
                <form method="POST" action="{{ $uploadUrl }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <input type="file" name="import_file" class="form-control" accept=".csv" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Import</button>
                    <a href="{{ admin_url('paolorox/restapro/ingredients') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
