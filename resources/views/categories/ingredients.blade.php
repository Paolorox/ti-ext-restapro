<div class="panel-body px-0 pb-0">
    @if (!isset($formModel) || !$formModel->exists)
        <div class="alert alert-info">
            <i class="fa fa-info-circle me-2"></i> Save the category first to see linked ingredients.
        </div>
    @else
        @php
            $ingredients = $formModel->ingredients()->with('unit')->get();
        @endphp

        <div class="d-flex justify-content-between align-items-center px-4 mb-3">
            <h5 class="mb-0 fw-bold text-dark" style="font-family: 'Inter', sans-serif;">Ingredients in {{ $formModel->name }}</h5>
            <a href="{{ admin_url('paolorox/restapro/ingredients/create') }}" class="btn btn-sm btn-primary shadow-sm" style="border-radius: 8px;">
                <i class="fa fa-plus me-1"></i> New Ingredient
            </a>
        </div>

        @if($ingredients->isEmpty())
            <div class="text-center py-5">
                <div class="text-muted mb-2"><i class="fa fa-folder-open fa-3x" style="opacity: 0.3;"></i></div>
                <p class="text-muted fw-medium">No ingredients found in this category.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-family: 'Inter', sans-serif;">
                    <thead style="background: rgba(248, 250, 252, 0.8);">
                        <tr>
                            <th class="text-muted fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; padding: 1rem 1.5rem;">Ingredient Name</th>
                            <th class="text-muted fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px; padding: 1rem 1.5rem;">SKU</th>
                            <th class="text-muted fw-semibold text-uppercase text-end" style="font-size: 0.75rem; letter-spacing: 0.5px; padding: 1rem 1.5rem;">In Stock</th>
                            <th class="text-muted fw-semibold text-uppercase text-end" style="font-size: 0.75rem; letter-spacing: 0.5px; padding: 1rem 1.5rem;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ingredients as $ingredient)
                            <tr style="transition: all 0.2s ease;">
                                <td style="padding: 1rem 1.5rem;">
                                    <div class="fw-bold text-dark">{{ $ingredient->name }}</div>
                                    @if(!$ingredient->is_active)
                                        <span class="badge bg-secondary" style="font-size: 0.65rem;">Inactive</span>
                                    @endif
                                </td>
                                <td style="padding: 1rem 1.5rem;">
                                    <span class="text-muted font-monospace" style="font-size: 0.85rem;">{{ $ingredient->sku ?: '-' }}</span>
                                </td>
                                <td class="text-end" style="padding: 1rem 1.5rem;">
                                    @php
                                        $stockColor = $ingredient->stock <= ($ingredient->minimum_stock ?: 0) ? 'text-danger' : 'text-success';
                                    @endphp
                                    <span class="fw-bold {{ $stockColor }}">{{ number_format($ingredient->stock, 2) }}</span>
                                    <span class="text-muted ms-1" style="font-size: 0.85rem;">{{ $ingredient->unit ? $ingredient->unit->name : '' }}</span>
                                </td>
                                <td class="text-end" style="padding: 1rem 1.5rem;">
                                    <a href="{{ admin_url('paolorox/restapro/ingredients/edit/' . $ingredient->id) }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 6px;">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif
</div>
