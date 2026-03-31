<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use App\Services\TelegramService;

class OrderController extends Controller
{
    public function store(Request $request, $product_id)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'address' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($product_id);
        $quantity = $request->quantity;
        $totalPrice = $product->price * $quantity;

        $order = Order::create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'address' => $request->address,
            'status' => 'pending',
        ]);

        // Dispatch Telegram notification to mitra via queue
        $order->load('product.mitra');
        TelegramService::dispatchMitraNotifications($order);

        $waMessage = "Halo LF Catalog, saya ingin memesan produk:" . PHP_EOL . PHP_EOL .
            "*Produk:* " . $product->name . PHP_EOL .
            "*Harga:* Rp " . number_format($product->price, 0, ',', '.') . PHP_EOL .
            "*Jumlah:* " . $quantity . PHP_EOL .
            "*Total:* Rp " . number_format($totalPrice, 0, ',', '.') . PHP_EOL .
            "*ID Pesanan:* " . $order->id . PHP_EOL . PHP_EOL .
            "*Data Pemesan:* " . PHP_EOL .
            "*Nama:* " . $request->customer_name . PHP_EOL .
            "*WhatsApp:* " . $request->customer_phone . PHP_EOL .
            "*Alamat:* " . $request->address . PHP_EOL . PHP_EOL .
            "Link produk: " . route('product.detail', $product->slug);

        $waUrl = "https://wa.me/6285231445771?text=" . urlencode($waMessage);

        return redirect()->away($waUrl);
    }
}

