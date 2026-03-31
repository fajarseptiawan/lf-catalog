<?php

namespace App\Services;

use App\Models\Order;

class WhatsAppService
{
    /**
     * Admin WhatsApp number (without +).
     */
    protected static string $adminPhone = '6285231445771';

    /**
     * Build a WhatsApp URL for the admin with the order summary.
     */
    public static function buildAdminUrl(Order $order): string
    {
        $message = self::buildMessage($order);
        return "https://wa.me/" . self::$adminPhone . "?text=" . urlencode($message);
    }

    /**
     * Build the formatted WhatsApp message.
     */
    protected static function buildMessage(Order $order): string
    {
        $lines = [];

        $lines[] = "📦 *PESANAN BARU — LF CATALOG*";
        $lines[] = "";
        $lines[] = "🧾 *Invoice:* " . $order->invoice_code;
        $lines[] = "👤 *Nama:* " . $order->customer_name;
        $lines[] = "📱 *WhatsApp:* " . $order->customer_phone;
        $lines[] = "📍 *Alamat:* " . $order->address;
        $lines[] = "📝 *Catatan:* " . ($order->notes ?: '-');
        $lines[] = "";
        $lines[] = "🛒 *ITEM PESANAN:*";

        $grandTotal = 0;

        // Multi-item order (new checkout system)
        if ($order->items && $order->items->count() > 0) {
            foreach ($order->items as $idx => $item) {
                $productName = $item->product->name ?? 'Produk';
                $subtotal = $item->price * $item->quantity;
                $grandTotal += $subtotal;
                $lines[] = ($idx + 1) . ". " . $productName
                    . " × " . $item->quantity
                    . " — Rp " . number_format($subtotal, 0, ',', '.');
            }
        }
        // Legacy single-product order
        elseif ($order->product) {
            $qty = $order->quantity ?? 1;
            $subtotal = $order->product->price * $qty;
            $grandTotal = $subtotal;
            $lines[] = "1. " . $order->product->name
                . " × " . $qty
                . " — Rp " . number_format($subtotal, 0, ',', '.');
        }

        $lines[] = "";
        $lines[] = "💰 *TOTAL: Rp " . number_format($grandTotal, 0, ',', '.') . "*";
        $lines[] = "";
        $lines[] = "Mohon konfirmasi pesanan ini. Terima kasih! 🙏";

        return implode("\n", $lines);
    }
}
