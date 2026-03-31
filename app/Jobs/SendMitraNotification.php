<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Mitra;
use App\Models\TelegramNotification;
use App\Services\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendMitraNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Seconds to wait before retrying.
     */
    public int $backoff = 10;

    public function __construct(
        protected int $orderId,
        protected int $mitraId,
        protected array $itemData
    ) {}

    public function handle(): void
    {
        $order = Order::with(['items.product'])->find($this->orderId);
        $mitra = Mitra::find($this->mitraId);

        if (!$order || !$mitra || !$mitra->telegram_chat_id) {
            Log::warning('SendMitraNotification: skipped', [
                'order_id' => $this->orderId,
                'mitra_id' => $this->mitraId,
                'reason'   => !$order ? 'order not found' : (!$mitra ? 'mitra not found' : 'no chat_id'),
            ]);
            return;
        }

        $telegram = new TelegramService();
        $message = $telegram->buildMitraMessageFromData($order, $mitra, $this->itemData);

        // Log the notification attempt
        $notification = TelegramNotification::create([
            'order_id' => $order->id,
            'mitra_id' => $mitra->id,
            'chat_id'  => $mitra->telegram_chat_id,
            'message'  => $message,
            'status'   => 'pending',
        ]);

        $result = $telegram->sendMessage($mitra->telegram_chat_id, $message);

        if ($result) {
            $notification->update([
                'status'  => 'sent',
                'sent_at' => now(),
            ]);

            Log::info('Telegram notification sent', [
                'order_id' => $order->id,
                'mitra'    => $mitra->store_name,
                'chat_id'  => $mitra->telegram_chat_id,
            ]);
        } else {
            $notification->update([
                'status' => 'failed',
                'error'  => 'Telegram API returned null',
            ]);

            Log::error('Telegram notification failed', [
                'order_id' => $order->id,
                'mitra'    => $mitra->store_name,
                'chat_id'  => $mitra->telegram_chat_id,
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        TelegramNotification::where('order_id', $this->orderId)
            ->where('mitra_id', $this->mitraId)
            ->where('status', 'pending')
            ->update([
                'status' => 'failed',
                'error'  => $exception->getMessage(),
            ]);

        Log::error('SendMitraNotification job failed permanently', [
            'order_id' => $this->orderId,
            'mitra_id' => $this->mitraId,
            'error'    => $exception->getMessage(),
        ]);
    }
}
