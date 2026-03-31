<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class MitraController extends Controller
{
    private function getMitra()
    {
        return Auth::user()->mitra;
    }

    public function dashboard()
    {
        $mitra = $this->getMitra();
        $mitraProductIds = Product::where('mitra_id', $mitra->id)->pluck('id');

        $totalProducts = $mitraProductIds->count();

        // Count orders: legacy (product_id in orders) + new (order_items)
        $legacyOrderCount = Order::whereIn('product_id', $mitraProductIds)->count();
        $multiOrderIds = OrderItem::whereIn('product_id', $mitraProductIds)->pluck('order_id')->unique();
        $totalOrders = Order::where(function ($q) use ($mitraProductIds, $multiOrderIds) {
            $q->whereIn('product_id', $mitraProductIds)
              ->orWhereIn('id', $multiOrderIds);
        })->count();

        // Revenue from paid orders
        $legacyRevenue = Order::whereIn('product_id', $mitraProductIds)
            ->where('status', 'paid')
            ->get()
            ->sum(fn($o) => ($o->product->price ?? 0) * ($o->quantity ?? 1));

        $multiRevenue = OrderItem::whereIn('product_id', $mitraProductIds)
            ->whereHas('order', fn($q) => $q->where('status', 'paid'))
            ->get()
            ->sum(fn($i) => $i->price * $i->quantity);

        $totalRevenue = $legacyRevenue + $multiRevenue;

        // Recent orders
        $recentOrders = Order::with(['product', 'items.product'])
            ->where(function ($q) use ($mitraProductIds, $multiOrderIds) {
                $q->whereIn('product_id', $mitraProductIds)
                  ->orWhereIn('id', $multiOrderIds);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('mitra.dashboard', compact(
            'mitra', 'totalProducts', 'totalOrders', 'totalRevenue', 'recentOrders'
        ));
    }

    public function products()
    {
        $mitra = $this->getMitra();
        $products = Product::where('mitra_id', $mitra->id)->latest()->get();
        return view('mitra.products', compact('mitra', 'products'));
    }

    public function orders()
    {
        $mitra = $this->getMitra();
        $mitraProductIds = Product::where('mitra_id', $mitra->id)->pluck('id');
        $multiOrderIds = OrderItem::whereIn('product_id', $mitraProductIds)->pluck('order_id')->unique();

        $orders = Order::with(['product', 'items.product'])
            ->where(function ($q) use ($mitraProductIds, $multiOrderIds) {
                $q->whereIn('product_id', $mitraProductIds)
                  ->orWhereIn('id', $multiOrderIds);
            })
            ->latest()
            ->get();

        $totalPending = $orders->where('status', 'pending')->count();
        $totalVerified = $orders->where('status', 'paid')->count();

        // Calculate revenue only for mitra's items
        $totalRevenue = 0;
        foreach ($orders->where('status', 'paid') as $order) {
            if ($order->items->count() > 0) {
                $totalRevenue += $order->items
                    ->whereIn('product_id', $mitraProductIds)
                    ->sum(fn($i) => $i->price * $i->quantity);
            } else {
                $totalRevenue += ($order->product->price ?? 0) * ($order->quantity ?? 1);
            }
        }

        return view('mitra.orders', compact('mitra', 'orders', 'totalPending', 'totalVerified', 'totalRevenue'));
    }
}
