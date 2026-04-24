<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Order;
use App\Models\StockHistory;
use App\Models\User;
use App\Models\Mitra;
use App\Models\Visitor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\TelegramService;

class AdminController extends Controller
{
    public function dashboard()
    {
        $productsCount = Product::count();
        $ordersCount = Order::where('status', 'paid')->count();
        $pendingOrders = Order::where('status', 'pending')->count();

        // Income statistics — combine legacy orders (product_id) + multi-item orders (order_items)
        $legacyIncomeToday = Order::where('orders.status', 'paid')
            ->whereNotNull('orders.product_id')
            ->whereDate('orders.created_at', now()->today())
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->sum(DB::raw('products.price * orders.quantity'));
        $multiIncomeToday = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->whereDate('orders.created_at', now()->today())
            ->sum(DB::raw('order_items.price * order_items.quantity'));
        $incomeToday = $legacyIncomeToday + $multiIncomeToday;

        $legacyIncomeMonth = Order::where('orders.status', 'paid')
            ->whereNotNull('orders.product_id')
            ->whereMonth('orders.created_at', now()->month)
            ->whereYear('orders.created_at', now()->year)
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->sum(DB::raw('products.price * orders.quantity'));
        $multiIncomeMonth = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->whereMonth('orders.created_at', now()->month)
            ->whereYear('orders.created_at', now()->year)
            ->sum(DB::raw('order_items.price * order_items.quantity'));
        $incomeMonth = $legacyIncomeMonth + $multiIncomeMonth;

        $legacyIncomeTotal = Order::where('orders.status', 'paid')
            ->whereNotNull('orders.product_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->sum(DB::raw('products.price * orders.quantity'));
        $multiIncomeTotal = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->sum(DB::raw('order_items.price * order_items.quantity'));
        $incomeTotal = $legacyIncomeTotal + $multiIncomeTotal;

        // Total pengeluaran belanja = akumulasi semua pembelian stok (kumulatif)
        $totalExpenditure = StockHistory::sum('total_cost');

        // Pesanan yang belum terverifikasi (pending)
        $pendingOrdersList = Order::with(['product', 'items.product'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        // Pesanan yang sudah terverifikasi (paid)
        $verifiedOrdersList = Order::with(['product', 'items.product'])
            ->where('status', 'paid')
            ->latest()
            ->get();

        return view('admin.dashboard', compact(
            'productsCount',
            'ordersCount',
            'pendingOrders',
            'incomeToday',
            'incomeMonth',
            'incomeTotal',
            'totalExpenditure',
            'pendingOrdersList',
            'verifiedOrdersList'
        ));
    }

    public function products()
    {
        $products = Product::with('mitra')->latest()->get();
        $stockHistories = StockHistory::with('product')->latest()->get();
        return view('admin.products.index', compact('products', 'stockHistories'));
    }

    public function createProduct()
    {
        $mitras = Mitra::orderBy('store_name')->get();
        return view('admin.products.create', compact('mitras'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category' => 'required',
            'price' => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $data = $request->only(['name', 'category', 'price', 'purchase_price', 'stock', 'description']);
            $data['is_temperedglass'] = $request->has('is_temperedglass');
            $data['mitra_id'] = $request->mitra_id ?: null;

            $data['slug'] = \Illuminate\Support\Str::slug($request->name);

            // Pastikan slug unik, tambahkan suffix angka jika sudah ada
            $originalSlug = $data['slug'];
            $counter = 2;
            while (Product::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Simpan gambar ke folder kategori: public/img/{category}/
            $categoryFolder = 'img/' . $data['category'];
            if (!file_exists(public_path($categoryFolder))) {
                mkdir(public_path($categoryFolder), 0755, true);
            }

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path($categoryFolder), $imageName);
                $data['image'] = $categoryFolder . '/' . $imageName;
            }
            else {
                $data['image'] = 'img/tes.png';
            }

            // Handle multiple images
            if ($request->hasFile('images')) {
                $imagesPaths = [];
                foreach ($request->file('images') as $idx => $img) {
                    $imgName = time() . '_' . $idx . '.' . $img->extension();
                    $img->move(public_path($categoryFolder), $imgName);
                    $imagesPaths[] = $categoryFolder . '/' . $imgName;
                }
                $data['images'] = $imagesPaths;
            }

            $product = Product::create($data);

            // Record stock history for new product
            if ($product->stock > 0) {
                StockHistory::create([
                    'product_id' => $product->id,
                    'type' => 'new_product',
                    'quantity' => $product->stock,
                    'purchase_price' => $product->purchase_price,
                    'total_cost' => $product->purchase_price * $product->stock,
                    'note' => 'Produk baru ditambahkan',
                ]);
            }

            return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan.');
        }
        catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $mitras = Mitra::orderBy('store_name')->get();
        return view('admin.products.edit', compact('product', 'mitras'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['name', 'category', 'price', 'purchase_price', 'stock', 'description']);
        $data['is_temperedglass'] = $request->has('is_temperedglass');
        $data['mitra_id'] = $request->mitra_id ?: null;
        $data['slug'] = \Illuminate\Support\Str::slug($request->name);

        // Pastikan slug unik (kecuali milik produk ini sendiri)
        $originalSlug = $data['slug'];
        $counter = 2;
        while (Product::where('slug', $data['slug'])->where('id', '!=', $product->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Simpan gambar ke folder kategori: public/img/{category}/
        $categoryFolder = 'img/' . $data['category'];
        if (!file_exists(public_path($categoryFolder))) {
            mkdir(public_path($categoryFolder), 0755, true);
        }

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path($categoryFolder), $imageName);
            $data['image'] = $categoryFolder . '/' . $imageName;
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            $imagesPaths = $product->images ?? [];
            foreach ($request->file('images') as $idx => $img) {
                $imgName = time() . '_' . $idx . '.' . $img->extension();
                $img->move(public_path($categoryFolder), $imgName);
                $imagesPaths[] = $categoryFolder . '/' . $imgName;
            }
            $data['images'] = $imagesPaths;
        }

        $product->update($data);

        // Update stock history if purchase_price changed
        if ($product->wasChanged('purchase_price')) {
            $newPrice = $product->purchase_price;
            StockHistory::where('product_id', $product->id)->each(function ($history) use ($newPrice) {
                $history->update([
                    'purchase_price' => $newPrice,
                    'total_cost' => $newPrice * $history->quantity,
                ]);
            });
        }

        return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui.');
    }

    public function restockProduct(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'purchase_price' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:500',
        ]);

        $product = Product::findOrFail($id);

        $quantity = $request->quantity;
        $purchasePrice = $request->purchase_price;
        $totalCost = $quantity * $purchasePrice;

        // Update product stock and purchase price
        $product->increment('stock', $quantity);
        $product->update(['purchase_price' => $purchasePrice]);

        // Record stock history
        StockHistory::create([
            'product_id' => $product->id,
            'type' => 'restock',
            'quantity' => $quantity,
            'purchase_price' => $purchasePrice,
            'total_cost' => $totalCost,
            'note' => $request->note ?? 'Penambahan stok',
        ]);

        return back()->with('success', "Berhasil menambahkan {$quantity} stok untuk {$product->name}.");
    }

    public function deleteStockHistory($id)
    {
        $history = StockHistory::findOrFail($id);
        $history->delete();
        return back()->with('success', 'Riwayat stok berhasil dihapus.');
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function deleteProductImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $imagePath = $request->input('image_path');
        $type = $request->input('type'); // 'main' or 'slider'

        if ($type === 'main') {
            // Delete old main image file (if not default)
            if ($product->image && $product->image !== 'img/tes.png' && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $product->update(['image' => 'img/tes.png']);
        }
        else {
            // Delete slider image
            $images = $product->images ?? [];
            $images = array_values(array_filter($images, fn($img) => $img !== $imagePath));

            if ($imagePath && file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }

            $product->update(['images' => $images]);
        }

        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    public function orders()
    {
        $orders = Order::with(['product', 'items.product'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function verifyOrder($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        if ($order->status === 'pending') {
            // Multi-item order
            if ($order->items->count() > 0) {
                // Check stock for all items first
                foreach ($order->items as $item) {
                    if (!$item->product || $item->product->stock < $item->quantity) {
                        $productName = $item->product?->name ?? 'Produk dihapus';
                        return back()->with('error', "Stok \"{$productName}\" tidak mencukupi.");
                    }
                }
                // Decrement stock for all items
                foreach ($order->items as $item) {
                    $item->product->decrement('stock', $item->quantity);
                }
                $order->update(['status' => 'paid']);

                // Kirim notifikasi Telegram ke mitra terkait
                TelegramService::dispatchMitraNotifications($order);

                return back()->with('success', 'Pesanan berhasil diverifikasi.');
            }

            // Legacy single-product order
            $product = $order->product;
            if (!$product) {
                return back()->with('error', 'Produk tidak ditemukan.');
            }
            $quantity = $order->quantity ?? 1;

            if ($product->stock >= $quantity) {
                $product->decrement('stock', $quantity);
                $order->update(['status' => 'paid']);

                // Kirim notifikasi Telegram ke mitra terkait
                TelegramService::dispatchMitraNotifications($order);

                return back()->with('success', "Pesanan berhasil diverifikasi. Stok berkurang {$quantity}.");
            }

            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        return back()->with('info', 'Pesanan sudah diverifikasi sebelumnya.');
    }

    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === 'pending') {
            $order->update(['status' => 'canceled']);
            return back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return back()->with('info', 'Hanya pesanan pending yang bisa dibatalkan.');
    }

    public function settings()
    {
        $admins = User::where('is_admin', true)->get();
        return view('admin.settings', compact('admins'));
    }



    public function addAdmin(Request $request)
    {
        // Check if email exists as a non-admin user, if so update to admin
        $existingUser = User::where('email', $request->email)->where('is_admin', false)->first();
        if ($existingUser) {
            $existingUser->update(['is_admin' => true]);
            return back()->with('success', 'User yang sudah ada berhasil dijadikan admin.');
        }

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'is_admin' => true,
        ]);

        return back()->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan admin lain.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = $request->password;
        }

        $admin->save();

        return back()->with('success', 'Data admin berhasil diperbarui.');
    }

    public function deleteAdmin($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $admin->delete();
        return back()->with('success', 'Admin berhasil dihapus.');
    }

    // ===== Mitra Management =====

    public function mitras()
    {
        $mitras = Mitra::with('user')->latest()->get();
        return view('admin.mitras.index', compact('mitras'));
    }

    public function storeMitra(Request $request)
    {
        $request->validate([
            'store_name' => 'required|max:255',
            'phone' => 'nullable|max:20',
            'address' => 'nullable|max:500',
            'telegram_chat_id' => 'nullable|max:50',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'store_name.required' => 'Nama toko wajib diisi.',
            'name.required' => 'Nama mitra wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'is_mitra' => true,
        ]);

        Mitra::create([
            'user_id' => $user->id,
            'store_name' => $request->store_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'telegram_chat_id' => $request->telegram_chat_id,
        ]);

        return back()->with('success', 'Mitra baru berhasil ditambahkan.');
    }

    public function updateMitra(Request $request, $id)
    {
        $mitra = Mitra::findOrFail($id);

        $request->validate([
            'store_name' => 'required|max:255',
            'phone' => 'nullable|max:20',
            'address' => 'nullable|max:500',
            'telegram_chat_id' => 'nullable|max:50',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $mitra->user_id,
            'password' => 'nullable|min:6|confirmed',
        ], [
            'store_name.required' => 'Nama toko wajib diisi.',
            'name.required' => 'Nama mitra wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $mitra->update([
            'store_name' => $request->store_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'telegram_chat_id' => $request->telegram_chat_id,
        ]);

        $user = $mitra->user;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = $request->password;
        }
        $user->save();

        return back()->with('success', 'Data mitra berhasil diperbarui.');
    }

    public function deleteMitra($id)
    {
        $mitra = Mitra::findOrFail($id);
        $user = $mitra->user;

        // Nullify mitra_id on products so they remain
        Product::where('mitra_id', $mitra->id)->update(['mitra_id' => null]);

        $mitra->delete();
        $user->delete();

        return back()->with('success', 'Mitra berhasil dihapus.');
    }

    public function toggleMitraStatus($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->update(['is_active' => !$mitra->is_active]);

        $status = $mitra->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Mitra {$mitra->store_name} berhasil {$status}.");
    }

    // ===== Telegram Sync =====

    public function syncTelegram()
    {
        $telegram = new \App\Services\TelegramService();
        $linked = $telegram->syncMitraChatIds();

        if (count($linked) > 0) {
            $names = collect($linked)->pluck('mitra')->join(', ');
            return back()->with('success', "Berhasil menghubungkan Telegram untuk: {$names}");
        }

        return back()->with('info', 'Tidak ada mitra baru yang terhubung. Pastikan mitra sudah mengirim /start KODE ke bot.');
    }

    public function regenerateLinkCode($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->update([
            'telegram_link_code' => Mitra::generateLinkCode(),
            'telegram_chat_id'   => null,
        ]);

        return back()->with('success', "Kode link Telegram untuk {$mitra->store_name} berhasil di-reset.");
    }

    // ===== Analytics / Visitor Tracking =====

    public function analytics()
    {
        $today = now()->toDateString();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Stat cards
        $visitorsToday = Visitor::whereDate('created_at', $today)->count();
        $uniqueVisitorsToday = Visitor::whereDate('created_at', $today)->distinct('ip_address')->count('ip_address');
        $visitorsMonth = Visitor::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)->count();
        $visitorsTotal = Visitor::count();
        $uniqueDevices = Visitor::distinct('ip_address')->count('ip_address');

        // Monthly chart data (last 12 months)
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = Visitor::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $uniqueCount = Visitor::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->distinct('ip_address')
                ->count('ip_address');
            $monthlyData[] = [
                'label' => $date->translatedFormat('M Y'),
                'total' => $count,
                'unique' => $uniqueCount,
            ];
        }

        // Daily summary (last 30 days)
        $dailySummary = DB::table('visitors')
            ->select(
                DB::raw('DATE(created_at) as visit_date'),
                DB::raw('COUNT(*) as total_visits'),
                DB::raw('COUNT(DISTINCT ip_address) as unique_visitors'),
                DB::raw("SUM(CASE WHEN device_type = 'Mobile' THEN 1 ELSE 0 END) as mobile_count"),
                DB::raw("SUM(CASE WHEN device_type = 'Desktop' THEN 1 ELSE 0 END) as desktop_count"),
                DB::raw("SUM(CASE WHEN device_type = 'Tablet' THEN 1 ELSE 0 END) as tablet_count"),
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderByDesc('visit_date')
            ->get();

        // Top browsers & OS (for daily summary enrichment)
        $dailyBrowsers = DB::table('visitors')
            ->select(
                DB::raw('DATE(created_at) as visit_date'),
                'browser',
                DB::raw('COUNT(*) as cnt')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy(DB::raw('DATE(created_at)'), 'browser')
            ->orderByDesc('cnt')
            ->get()
            ->groupBy('visit_date');

        $dailyOS = DB::table('visitors')
            ->select(
                DB::raw('DATE(created_at) as visit_date'),
                'os',
                DB::raw('COUNT(*) as cnt')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy(DB::raw('DATE(created_at)'), 'os')
            ->orderByDesc('cnt')
            ->get()
            ->groupBy('visit_date');

        // Enrich daily summary with top browser/OS
        foreach ($dailySummary as $day) {
            $day->top_browser = isset($dailyBrowsers[$day->visit_date])
                ? $dailyBrowsers[$day->visit_date]->first()->browser
                : '-';
            $day->top_os = isset($dailyOS[$day->visit_date])
                ? $dailyOS[$day->visit_date]->first()->os
                : '-';
        }

        // Today's visitor detail
        $todayVisitors = Visitor::whereDate('created_at', $today)
            ->latest()
            ->get();

        // Top pages today
        $topPages = Visitor::whereDate('created_at', $today)
            ->select('url', DB::raw('COUNT(*) as visits'))
            ->groupBy('url')
            ->orderByDesc('visits')
            ->limit(10)
            ->get();

        return view('admin.analytics', compact(
            'visitorsToday',
            'uniqueVisitorsToday',
            'visitorsMonth',
            'visitorsTotal',
            'uniqueDevices',
            'monthlyData',
            'dailySummary',
            'todayVisitors',
            'topPages'
        ));
    }
}
