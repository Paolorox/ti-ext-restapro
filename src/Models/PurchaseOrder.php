<?php

namespace Paolorox\Restapro\Models;

use Igniter\Flame\Database\Model;

class PurchaseOrder extends Model
{
    protected $table = 'fc_purchase_orders';

    protected $fillable = [
        'supplier_id',
        'reference',
        'status',
        'total_cost',
        'notes',
        'order_date',
        'received_date',
        'user_id',
    ];

    protected $casts = [
        'supplier_id' => 'integer',
        'total_cost' => 'float',
        'order_date' => 'date',
        'received_date' => 'date',
        'user_id' => 'integer',
    ];

    public const STATUS_DRAFT = 'draft';
    public const STATUS_ORDERED = 'ordered';
    public const STATUS_RECEIVED = 'received';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_DRAFT => 'Draft',
        self::STATUS_ORDERED => 'Ordered',
        self::STATUS_RECEIVED => 'Received',
        self::STATUS_CANCELLED => 'Cancelled',
    ];

    public $relation = [
        'belongsTo' => [
            'supplier' => [Supplier::class, 'foreignKey' => 'supplier_id'],
        ],
        'hasMany' => [
            'items' => [PurchaseOrderItem::class, 'foreignKey' => 'purchase_order_id'],
        ],
    ];

    public function scopeOfStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function getStatusNameAttribute(): string
    {
        return lang('paolorox.restapro::default.purchase_order_status_' . $this->status);
    }

    public function recalculateTotal(): void
    {
        $this->total_cost = $this->items->sum(function ($item) {
            return $item->quantity * $item->unit_cost;
        });
        $this->saveQuietly();
    }

    public function getStatusOptions(): array
    {
        return [
            self::STATUS_DRAFT => lang('paolorox.restapro::default.purchase_order_status_draft'),
            self::STATUS_ORDERED => lang('paolorox.restapro::default.purchase_order_status_ordered'),
            self::STATUS_RECEIVED => lang('paolorox.restapro::default.purchase_order_status_received'),
            self::STATUS_CANCELLED => lang('paolorox.restapro::default.purchase_order_status_cancelled'),
        ];
    }

    public function afterSave()
    {
        $this->saveItems();
        $this->processReceiptIfNeeded();
    }

    /**
     * Se l'ordine è (o è appena diventato) "Ricevuto" e non è ancora stato
     * scaricato a magazzino, genera i movimenti di carico. Idempotente:
     * usa l'esistenza di movimenti collegati come guardia anti-doppione, così
     * funziona sia dal pulsante "Segna come Ricevuto" sia dal semplice
     * cambio del campo Stato + Salva.
     */
    protected function processReceiptIfNeeded(): void
    {
        if ($this->status !== self::STATUS_RECEIVED) {
            return;
        }

        $alreadyProcessed = \Paolorox\Restapro\Models\StockMovement::query()
            ->where('reference_type', 'purchase_order')
            ->where('reference_id', (string) $this->getKey())
            ->exists();

        if ($alreadyProcessed) {
            return;
        }

        if (!$this->received_date) {
            $this->received_date = now();
            $this->saveQuietly();
        }

        app(\Paolorox\Restapro\Services\InventoryEngine::class)
            ->processPurchaseOrder($this);
    }

    protected function saveItems()
    {
        $itemsData = post('PurchaseOrder.items') ?: post('items');

        if (!is_array($itemsData)) {
            return;
        }

        $this->items()->delete();

        foreach ($itemsData as $data) {
            $ingredientId = !empty($data['ingredient_id']) ? (int)$data['ingredient_id'] : null;
            $quantity = !empty($data['quantity']) ? (float)$data['quantity'] : 0.0;
            $unitCost = !empty($data['unit_cost']) ? (float)$data['unit_cost'] : 0.0;
            $unitId = !empty($data['unit_id']) ? (int)$data['unit_id'] : null;
            $expiryDate = !empty($data['expiry_date']) ? $data['expiry_date'] : null;

            if ($ingredientId && $quantity > 0 && $unitId) {
                $this->items()->create([
                    'ingredient_id' => $ingredientId,
                    'quantity' => $quantity,
                    'unit_cost' => $unitCost,
                    'unit_id' => $unitId,
                    'expiry_date' => $expiryDate,
                ]);
            }
        }

        // Ricarica la relazione (bust della cache) prima di ricalcolare il totale
        $this->load('items');
        $this->recalculateTotal();
    }
}
