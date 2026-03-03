<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'customer_name',
        'customer_phone',
        'address',
        'status',
        'payment_proof',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
