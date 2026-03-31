<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramNotification extends Model
{
    protected $fillable = [
        'order_id',
        'mitra_id',
        'chat_id',
        'message',
        'status',
        'error',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }
}
