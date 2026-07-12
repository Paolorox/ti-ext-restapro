<style>
    .premium-table th { font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; color: #64748b; border-bottom: 2px solid #f1f5f9; padding: 1rem; }
    .premium-table td { vertical-align: middle; padding: 1rem; color: #334155; border-bottom: 1px solid #f1f5f9; }
</style>
<div class="table-responsive">
    <table class="table premium-table mb-0">
        <thead class="bg-light">
            <tr>
                <th>Order Reference</th>
                <th>Order Date</th>
                <th>Received Date</th>
                <th>Status</th>
                <th>Total Cost</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
                $orders = \Paolorox\Restapro\Models\PurchaseOrder::where('supplier_id', $formModel->id)
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();
            @endphp
            @forelse($orders as $order)
                <tr>
                    <td class="fw-semibold">{{ $order->reference ?? 'PO-'.str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="text-muted">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="text-muted">{{ $order->received_date ? $order->received_date->format('d M Y') : '—' }}</td>
                    <td>
                        <span class="badge bg-{{ $order->status === 'completed' || $order->status === 'received' ? 'success' : ($order->status === 'pending' || $order->status === 'ordered' ? 'warning' : 'secondary') }} bg-opacity-10 text-{{ $order->status === 'completed' || $order->status === 'received' ? 'success' : ($order->status === 'pending' || $order->status === 'ordered' ? 'warning' : 'secondary') }} px-3 py-1 rounded-pill">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="fw-bold">@lang('paolorox.restapro::default.currency_symbol'){{ number_format($order->total_cost, 2) }}</td>
                    <td>
                        <a href="{{ admin_url('paolorox/restapro/purchaseorders/edit/' . $order->id) }}" class="btn btn-sm btn-light text-primary rounded-pill px-3">
                            <i class="fa fa-eye me-1"></i> View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="fa fa-file-invoice fa-2x mb-2 text-light"></i>
                        <div>No purchase orders found for this supplier.</div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3 text-end px-3 pb-3">
        <a href="{{ admin_url('paolorox/restapro/purchaseorders?filter[supplier]=' . $formModel->id) }}" class="btn btn-outline-primary rounded-pill px-4">View All Orders</a>
    </div>
</div>
