<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'invoice_code',
        'product_id',
        'quantity',
        'customer_name',
        'customer_phone',
        'address',
        'notes',
        'status',
        'payment_proof',
    ];

    /**
     * Legacy: single product relation (old orders).
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * New: multi-product order items.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Check if this is a multi-item order.
     */
    public function isMultiItem()
    {
        return $this->items()->exists();
    }

    /**
     * Get total price for this order.
     */
    public function getTotalAttribute()
    {
        if ($this->items()->exists()) {
            return $this->items->sum(fn($item) => $item->price * $item->quantity);
        }
        // Legacy single-product
        return ($this->product->price ?? 0) * ($this->quantity ?? 1);
    }

    /**
     * Generate a unique invoice code.
     */
    public static function generateInvoice()
    {
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return 'INV-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
