<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Order;
use App\Models\StockHistory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $productsCount = Product::count();
        $ordersCount = Order::where('status', 'paid')->count();
        $pendingOrders = Order::where('status', 'pending')->count();

        // Income statistics
        $incomeToday = Order::where('orders.status', 'paid')
            ->whereDate('orders.created_at', now()->today())
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->sum(DB::raw('products.price * orders.quantity'));

        $incomeMonth = Order::where('orders.status', 'paid')
            ->whereMonth('orders.created_at', now()->month)
            ->whereYear('orders.created_at', now()->year)
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->sum(DB::raw('products.price * orders.quantity'));

        $incomeTotal = Order::where('orders.status', 'paid')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->sum(DB::raw('products.price * orders.quantity'));

        // Total pengeluaran belanja = akumulasi semua pembelian stok (kumulatif)
        $totalExpenditure = StockHistory::sum('total_cost');

        // Pesanan yang belum terverifikasi (pending)
        $pendingOrdersList = Order::with('product')
            ->where('status', 'pending')
            ->latest()
            ->get();

        // Pesanan yang sudah terverifikasi (paid)
        $verifiedOrdersList = Order::with('product')
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
        $products = Product::latest()->get();
        $stockHistories = StockHistory::with('product')->latest()->get();
        return view('admin.products.index', compact('products', 'stockHistories'));
    }

    public function createProduct()
    {
        return view('admin.products.create');
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

            $data['slug'] = \Illuminate\Support\Str::slug($request->name);

            // Pastikan slug unik, tambahkan suffix angka jika sudah ada
            $originalSlug = $data['slug'];
            $counter = 2;
            while (Product::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('img'), $imageName);
                $data['image'] = 'img/' . $imageName;
            }
            else {
                $data['image'] = 'img/tes.png';
            }

            // Handle multiple images
            if ($request->hasFile('images')) {
                $imagesPaths = [];
                foreach ($request->file('images') as $idx => $img) {
                    $imgName = time() . '_' . $idx . '.' . $img->extension();
                    $img->move(public_path('img'), $imgName);
                    $imagesPaths[] = 'img/' . $imgName;
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
        return view('admin.products.edit', compact('product'));
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
        $data['slug'] = \Illuminate\Support\Str::slug($request->name);

        // Pastikan slug unik (kecuali milik produk ini sendiri)
        $originalSlug = $data['slug'];
        $counter = 2;
        while (Product::where('slug', $data['slug'])->where('id', '!=', $product->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('img'), $imageName);
            $data['image'] = 'img/' . $imageName;
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            $imagesPaths = $product->images ?? [];
            foreach ($request->file('images') as $idx => $img) {
                $imgName = time() . '_' . $idx . '.' . $img->extension();
                $img->move(public_path('img'), $imgName);
                $imagesPaths[] = 'img/' . $imgName;
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
        $orders = Order::with('product')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function verifyOrder($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === 'pending') {
            $product = $order->product;
            $quantity = $order->quantity ?? 1;

            if ($product->stock >= $quantity) {
                $product->decrement('stock', $quantity);
                $order->update(['status' => 'paid']);
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
}
