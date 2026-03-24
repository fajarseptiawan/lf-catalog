<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'price',
        'purchase_price',
        'stock',
        'description',
        'features',
        'image',
        'images',
        'is_featured',
        'is_temperedglass',
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_temperedglass' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
