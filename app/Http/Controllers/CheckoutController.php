<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\WhatsAppService;
use App\Services\TelegramService;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Show checkout page.
     */
    public function index()
    {
        return view('page.checkout');
    }

    /**
     * Process checkout from cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'address'        => 'required|string',
            'notes'          => 'nullable|string|max:500',
            'items'          => 'required|string', // JSON string of cart items
        ]);

        $items = json_decode($request->items, true);

        if (empty($items) || !is_array($items)) {
            return back()->withErrors(['items' => 'Keranjang kosong.'])->withInput();
        }

        // Validate all products exist and have sufficient stock
        $errors = [];
        $validItems = [];
        foreach ($items as $item) {
            $product = Product::find($item['id'] ?? 0);
            if (!$product) {
                $errors[] = "Produk \"{$item['name']}\" tidak ditemukan.";
                continue;
            }
            $qty = max(1, intval($item['qty'] ?? 1));
            if ($product->stock < $qty) {
                $errors[] = "Stok \"{$product->name}\" tidak mencukupi (sisa: {$product->stock}).";
                continue;
            }
            $validItems[] = [
                'product' => $product,
                'qty'     => $qty,
            ];
        }

        if (!empty($errors)) {
            return back()->withErrors(['items' => implode(' ', $errors)])->withInput();
        }

        // Create order + items in a transaction
        $order = DB::transaction(function () use ($request, $validItems) {
            $order = Order::create([
                'invoice_code'   => Order::generateInvoice(),
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'address'        => $request->address,
                'notes'          => $request->notes,
                'status'         => 'pending',
            ]);

            foreach ($validItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product']->id,
                    'quantity'   => $item['qty'],
                    'price'      => $item['product']->price,
                ]);
            }

            return $order;
        });

        // Dispatch Telegram notifications to mitra(s) via queue
        $order->load('items.product.mitra');
        TelegramService::dispatchMitraNotifications($order);

        return redirect()->route('checkout.success', $order->invoice_code);
    }

    /**
     * Show success page after checkout.
     */
    public function success($invoice)
    {
        $order = Order::where('invoice_code', $invoice)
            ->with('items.product')
            ->firstOrFail();

        $whatsappUrl = WhatsAppService::buildAdminUrl($order);

        return view('page.checkout-success', compact('order', 'whatsappUrl'));
    }
}
