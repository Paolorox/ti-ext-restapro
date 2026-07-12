<style>
    .premium-table th { font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; color: #64748b; border-bottom: 2px solid #f1f5f9; padding: 1rem; }
    .premium-table td { vertical-align: middle; padding: 1rem; color: #334155; border-bottom: 1px solid #f1f5f9; }
</style>
<div class="table-responsive">
    <table class="table premium-table mb-0">
        <thead class="bg-light">
            <tr>
                <th>Recipe Name</th>
                <th>Menu Item</th>
                <th>Quantity Required</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Fetch recipes that contain this ingredient
                $recipes = \Paolorox\Restapro\Models\Recipe::whereHas('recipeIngredients', function($q) use ($formModel) {
                    $q->where('ingredient_id', $formModel->id);
                })->with(['menu', 'recipeIngredients'])->get();
            @endphp
            @forelse($recipes as $recipe)
                @php
                    $line = $recipe->recipeIngredients->firstWhere('ingredient_id', $formModel->id);
                    $qty = $line ? $line->quantity : 0;
                @endphp
                <tr>
                    <td class="fw-semibold">
                        <a href="{{ admin_url('paolorox/restapro/recipes/edit/' . $recipe->id) }}" class="text-decoration-none text-dark">
                            {{ $recipe->name }}
                        </a>
                    </td>
                    <td><span class="badge bg-light text-dark">{{ $recipe->menu ? $recipe->menu->menu_name : 'No Menu Linked' }}</span></td>
                    <td class="fw-bold">{{ number_format($qty, 3) }}</td>
                    <td>
                        <span class="badge bg-{{ $recipe->is_active ? 'success' : 'secondary' }} rounded-pill px-3">
                            {{ $recipe->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-5">
                        <i class="fa fa-info-circle fa-2x mb-2 text-light"></i>
                        <div>This ingredient is not used in any recipes.</div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
