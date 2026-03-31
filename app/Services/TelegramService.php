<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Mitra;
use App\Jobs\SendMitraNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $apiUrl;

    public function __construct()
    {
        $token = config('services.telegram.bot_token');
        $this->apiUrl = "https://api.telegram.org/bot{$token}";
    }

    // ===== Core API Methods =====

    /**
     * Send a text message to a specific chat.
     */
    public function sendMessage(string|int $chatId, string $message, string $parseMode = 'Markdown'): ?array
    {
        try {
            $response = Http::post("{$this->apiUrl}/sendMessage", [
                'chat_id'    => $chatId,
                'text'       => $message,
                'parse_mode' => $parseMode,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Telegram sendMessage failed', [
                'chat_id'  => $chatId,
                'status'   => $response->status(),
                'response' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Telegram sendMessage exception', [
                'chat_id' => $chatId,
                'error'   => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Get recent updates (messages) from the bot.
     */
    public function getUpdates(int $offset = 0): array
    {
        try {
            $params = ['timeout' => 5];
            if ($offset > 0) {
                $params['offset'] = $offset;
            }

            $response = Http::post("{$this->apiUrl}/getUpdates", $params);

            if ($response->successful()) {
                return $response->json()['result'] ?? [];
            }

            return [];
        } catch (\Exception $e) {
            Log::error('Telegram getUpdates failed', ['error' => $e->getMessage()]);
            return [];
        }
    }

    // ===== Mitra Linking =====

    /**
     * Sync mitra Telegram chat IDs by checking /start messages.
     */
    public function syncMitraChatIds(): array
    {
        $updates = $this->getUpdates();
        $linked = [];
        $maxUpdateId = 0;

        foreach ($updates as $update) {
            $updateId = $update['update_id'] ?? 0;
            if ($updateId > $maxUpdateId) {
                $maxUpdateId = $updateId;
            }

            $message = $update['message'] ?? null;
            if (!$message || !isset($message['text'])) {
                continue;
            }

            $text = trim($message['text']);
            $chatId = $message['chat']['id'] ?? null;
            $senderName = trim(($message['from']['first_name'] ?? '') . ' ' . ($message['from']['last_name'] ?? ''));

            if (!$chatId) {
                continue;
            }

            if (preg_match('/^\/start\s+([A-Za-z0-9]{6})$/i', $text, $matches)) {
                $code = strtoupper($matches[1]);
                $mitra = Mitra::where('telegram_link_code', $code)->first();

                if ($mitra && !$mitra->telegram_chat_id) {
                    $mitra->update([
                        'telegram_chat_id'   => (string) $chatId,
                        'telegram_link_code' => null,
                    ]);

                    $linked[] = [
                        'mitra'    => $mitra->store_name,
                        'chat_id'  => $chatId,
                        'telegram' => $senderName,
                    ];

                    $this->sendMessage($chatId,
                        "✅ *Berhasil terhubung!*\n\n" .
                        "Akun Telegram Anda sekarang terhubung dengan *{$mitra->store_name}* di LF Catalog.\n\n" .
                        "Anda akan menerima notifikasi pesanan secara otomatis. 🔔"
                    );
                } elseif ($mitra && $mitra->telegram_chat_id) {
                    $this->sendMessage($chatId,
                        "ℹ️ Akun *{$mitra->store_name}* sudah terhubung ke Telegram sebelumnya."
                    );
                }
            } elseif ($text === '/start') {
                $this->sendMessage($chatId,
                    "👋 Halo! Saya bot *LF Catalog*.\n\n" .
                    "Untuk menghubungkan akun mitra Anda, kirim:\n" .
                    "`/start KODE_ANDA`\n\n" .
                    "Kode bisa didapat dari admin."
                );
            }
        }

        if ($maxUpdateId > 0) {
            $this->getUpdates($maxUpdateId + 1);
        }

        return $linked;
    }

    // ===== Order Notifications =====

    /**
     * Dispatch queue jobs to notify mitra(s) about an order.
     * Each mitra gets their own job for reliability.
     */
    public static function dispatchMitraNotifications(Order $order): void
    {
        // Multi-item order (new checkout)
        if ($order->items && $order->items->count() > 0) {
            $grouped = [];
            foreach ($order->items as $item) {
                $product = $item->product;
                if (!$product || !$product->mitra_id) {
                    continue;
                }
                $mitraId = $product->mitra_id;
                if (!isset($grouped[$mitraId])) {
                    $grouped[$mitraId] = [];
                }
                $grouped[$mitraId][] = [
                    'product_name' => $product->name,
                    'quantity'     => $item->quantity,
                    'price'        => $item->price,
                ];
            }

            foreach ($grouped as $mitraId => $itemData) {
                SendMitraNotification::dispatch($order->id, $mitraId, $itemData);
            }

            return;
        }

        // Legacy single-product order
        if ($order->product && $order->product->mitra_id) {
            $itemData = [[
                'product_name' => $order->product->name,
                'quantity'     => $order->quantity ?? 1,
                'price'        => $order->product->price,
            ]];
            SendMitraNotification::dispatch($order->id, $order->product->mitra_id, $itemData);
        }
    }

    /**
     * Build a formatted Telegram message from serializable data.
     * Used by the queue job (no Eloquent models needed).
     */
    public function buildMitraMessageFromData(Order $order, Mitra $mitra, array $itemData): string
    {
        $lines = [];
        $lines[] = "🔔 *PESANAN BARU*";
        $lines[] = "";
        $lines[] = "Halo *{$mitra->store_name}*! Ada pesanan masuk:";
        $lines[] = "";
        $lines[] = "🧾 Invoice: `{$order->invoice_code}`";
        $lines[] = "👤 Pembeli: {$order->customer_name}";
        $lines[] = "📱 WA: {$order->customer_phone}";
        $lines[] = "📍 Alamat: {$order->address}";

        if ($order->notes) {
            $lines[] = "📝 Catatan: {$order->notes}";
        }

        $lines[] = "";
        $lines[] = "🛒 *Produk Anda yang dipesan:*";

        $subtotal = 0;
        foreach ($itemData as $idx => $item) {
            $name = $item['product_name'];
            $qty  = $item['quantity'];
            $price = $item['price'];
            $total = $price * $qty;
            $subtotal += $total;

            $lines[] = ($idx + 1) . ". {$name}";
            $lines[] = "   {$qty} × Rp " . number_format($price, 0, ',', '.') . " = Rp " . number_format($total, 0, ',', '.');
        }

        $lines[] = "";
        $lines[] = "💰 *Subtotal: Rp " . number_format($subtotal, 0, ',', '.') . "*";
        $lines[] = "";
        $lines[] = "Mohon segera siapkan pesanan ini. Terima kasih! 🙏";

        return implode("\n", $lines);
    }
}
