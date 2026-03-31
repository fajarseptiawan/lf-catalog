<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Mitra extends Model
{
    protected $fillable = [
        'user_id',
        'store_name',
        'phone',
        'address',
        'telegram_chat_id',
        'telegram_link_code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($mitra) {
            if (!$mitra->telegram_link_code) {
                $mitra->telegram_link_code = self::generateLinkCode();
            }
        });
    }

    /**
     * Generate a unique 6-character link code.
     */
    public static function generateLinkCode(): string
    {
        do {
            $code = strtoupper(Str::random(6));
        } while (self::where('telegram_link_code', $code)->exists());

        return $code;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
