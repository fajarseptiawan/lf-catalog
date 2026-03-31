@extends('layouts.admin')

@section('title', 'Admin Dashboard - LF Catalog')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard Admin</h1>
    <p class="text-gray-500">Selamat datang kembali! Berikut ringkasan performa toko Anda.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="p-2 bg-blue-50 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Total Produk</p>
        <p class="text-3xl font-bold text-gray-900">{{ $productsCount }}</p>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="p-2 bg-green-50 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
        </div>
        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Total Pesanan Terverifikasi</p>
        <p class="text-3xl font-bold text-gray-900">{{ $ordersCount }}</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="p-2 bg-orange-50 rounded-lg">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Pesanan Pending</p>
        <p class="text-3xl font-bold text-orange-600">{{ $pendingOrders }}</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 border-l-4 border-l-purple-500">
        <div class="flex items-center justify-between mb-4">
            <div class="p-2 bg-purple-50 rounded-lg">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Pendapatan Hari Ini</p>
        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($incomeToday, 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-8 rounded-2xl shadow-lg border border-transparent text-white">
        <p class="text-blue-100 text-sm font-medium uppercase tracking-wider mb-2">Pendapatan Bulan Ini</p>
        <p class="text-4xl font-extrabold mb-4">Rp {{ number_format($incomeMonth, 0, ',', '.') }}</p>
        <div class="flex items-center text-sm text-blue-100">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            Terverifikasi otomatis
        </div>
    </div>

    <div class="bg-gradient-to-br from-emerald-600 to-teal-700 p-8 rounded-2xl shadow-lg border border-transparent text-white">
        <p class="text-emerald-100 text-sm font-medium uppercase tracking-wider mb-2">Pendapatan Tetap (Total)</p>
        <p class="text-4xl font-extrabold mb-4">Rp {{ number_format($incomeTotal, 0, ',', '.') }}</p>
        <div class="flex items-center text-sm text-emerald-100">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            Sudah masuk ke sistem
        </div>
    </div>

    <div class="bg-gradient-to-br from-rose-600 to-red-700 p-8 rounded-2xl shadow-lg border border-transparent text-white">
        <p class="text-rose-100 text-sm font-medium uppercase tracking-wider mb-2">Total Pengeluaran Belanja</p>
        <p class="text-4xl font-extrabold mb-4">Rp {{ number_format($totalExpenditure, 0, ',', '.') }}</p>
        <div class="flex items-center text-sm text-rose-100">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            Akumulasi harga beli × stok
        </div>
    </div>
</div>

<!-- Tabel Transaksi Belum Terverifikasi -->
<div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Transaksi Belum Terverifikasi</h2>
            <p class="text-sm text-gray-500">Pesanan yang menunggu konfirmasi pembayaran</p>
        </div>
        @if($pendingOrdersList->count() > 0)
        <span class="bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-full">{{ $pendingOrdersList->count() }} pending</span>
        @endif
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Total Harga</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pembeli</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pendingOrdersList as $order)
                @php
                    $isMulti = $order->items->count() > 0;
                    if ($isMulti) {
                        $orderItems = $order->items->filter(fn($i) => $i->product);
                        $firstProduct = $orderItems->first()?->product;
                        $totalQty = $orderItems->sum('quantity');
                        $totalPrice = $orderItems->sum(fn($i) => $i->price * $i->quantity);
                        $productNames = $orderItems->map(fn($i) => $i->product->name)->join(', ');
                    } else {
                        $firstProduct = $order->product;
                        $totalQty = $order->quantity ?? 1;
                        $totalPrice = $firstProduct ? ($firstProduct->price * $totalQty) : 0;
                        $productNames = $firstProduct?->name ?? 'Produk dihapus';
                    }
                @endphp
                @if($isMulti || $firstProduct)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-mono text-sm text-gray-500">
                        #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($firstProduct)
                            <img src="{{ asset($firstProduct->image) }}" alt="{{ $firstProduct->name }}" class="w-10 h-10 object-contain bg-gray-50 rounded-lg border border-gray-100 p-1">
                            @endif
                            <div>
                                <div class="font-semibold text-gray-900 text-sm">{{ $productNames }}</div>
                                @if($isMulti && $orderItems->count() > 1)
                                <div class="text-xs text-gray-400">{{ $orderItems->count() }} produk</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        Rp {{ number_format($totalPrice / max($totalQty, 1), 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 text-center">
                        {{ $totalQty }}
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-900">
                        Rp {{ number_format($totalPrice, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</div>
                        <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-600 line-clamp-2 max-w-xs">{{ $order->address }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <div class="flex justify-end gap-2">
                            <form id="verify-form-{{ $order->id }}" action="{{ route('admin.orders.verify', $order->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="button" onclick="openVerifyModal({{ $order->id }})" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-semibold transition">
                                    Verifikasi
                                </button>
                            </form>
                            <form id="cancel-form-{{ $order->id }}" action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="button" onclick="openCancelModal({{ $order->id }})" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-xs font-semibold transition">
                                    Batal
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center text-gray-400 italic">
                        <div class="flex flex-col items-center">
                            <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Semua transaksi sudah terverifikasi. 🎉
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Tabel Transaksi Terverifikasi (DataTable-style) -->
<div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Riwayat Transaksi Terverifikasi</h2>
                <p class="text-sm text-gray-500">Semua transaksi yang sudah berhasil diverifikasi</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 items-end">
                <!-- Date Filter -->
                <div class="flex items-center gap-2 bg-gray-50 rounded-2xl px-4 py-2 border border-gray-200">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-xs font-semibold text-gray-500 uppercase">Dari</span>
                        <input type="text" id="dateFrom" class="flatpickr-input px-3 py-1.5 text-sm bg-white border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition cursor-pointer w-32" placeholder="Pilih tanggal" readonly>
                    </div>
                    <span class="text-gray-300 text-lg">→</span>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-500 uppercase">Sampai</span>
                        <input type="text" id="dateTo" class="flatpickr-input px-3 py-1.5 text-sm bg-white border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition cursor-pointer w-32" placeholder="Pilih tanggal" readonly>
                    </div>
                    <button onclick="resetDateFilter()" class="ml-1 p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Reset filter tanggal">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <!-- Search -->
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="searchVerified" class="pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white outline-none transition w-full sm:w-64" placeholder="Cari nama, produk, telepon..." oninput="filterVerifiedTable()">
                </div>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left" id="verifiedTable">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Total Harga</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pembeli</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100" id="verifiedTableBody">
                @forelse($verifiedOrdersList as $index => $order)
                @php
                    $isMultiV = $order->items->count() > 0;
                    if ($isMultiV) {
                        $vItems = $order->items->filter(fn($i) => $i->product);
                        $vFirstProduct = $vItems->first()?->product;
                        $vTotalQty = $vItems->sum('quantity');
                        $vTotalPrice = $vItems->sum(fn($i) => $i->price * $i->quantity);
                        $vProductNames = $vItems->map(fn($i) => $i->product->name)->join(', ');
                    } else {
                        $vFirstProduct = $order->product;
                        $vTotalQty = $order->quantity ?? 1;
                        $vTotalPrice = $vFirstProduct ? ($vFirstProduct->price * $vTotalQty) : 0;
                        $vProductNames = $vFirstProduct?->name ?? 'Produk dihapus';
                    }
                @endphp
                @if($isMultiV && $vItems->count() > 0 || !$isMultiV && $vFirstProduct)
                <tr class="hover:bg-gray-50 transition verified-row"
                    data-search="{{ strtolower($order->customer_name . ' ' . $order->customer_phone . ' ' . $vProductNames . ' ' . $order->address) }}"
                    data-date="{{ $order->created_at->format('Y-m-d') }}"
                    data-price-raw="{{ $vTotalPrice }}"
                    data-quantity="{{ $vTotalQty }}"
                    data-total="{{ $vTotalPrice }}"
                    data-product-name="{{ $vProductNames }}"
                    data-customer-name="{{ $order->customer_name }}"
                    data-customer-phone="{{ $order->customer_phone }}"
                    data-order-date="{{ $order->created_at->format('d/m/Y H:i') }}">
                    <td class="px-6 py-4 text-sm text-gray-500 row-number">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-mono text-sm text-gray-500">
                        #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($vFirstProduct)
                            <img src="{{ asset($vFirstProduct->image) }}" alt="{{ $vFirstProduct->name }}" class="w-10 h-10 object-contain bg-gray-50 rounded-lg border border-gray-100 p-1">
                            @endif
                            <div>
                                <div class="font-semibold text-gray-900 text-sm">{{ $vProductNames }}</div>
                                @if($isMultiV && $vItems->count() > 1)
                                <div class="text-xs text-gray-400">{{ $vItems->count() }} produk</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        Rp {{ number_format($vTotalPrice / max($vTotalQty, 1), 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 text-center">
                        {{ $vTotalQty }}
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-900">
                        Rp {{ number_format($vTotalPrice, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</div>
                        <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-600 line-clamp-2 max-w-xs">{{ $order->address }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-semibold border border-green-100">LUNAS</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button onclick="printReceipt(this)" 
                            data-id="#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}"
                            data-name="{{ $order->customer_name }}"
                            data-phone="{{ $order->customer_phone }}"
                            data-address="{{ $order->address }}"
                            data-product="{{ $vProductNames }}"
                            data-price="Rp {{ number_format($vTotalPrice / max($vTotalQty, 1), 0, ',', '.') }}"
                            data-quantity="{{ $vTotalQty }}"
                            data-total="Rp {{ number_format($vTotalPrice, 0, ',', '.') }}"
                            data-date="{{ $order->created_at->format('d/m/Y H:i') }}"
                            class="inline-flex items-center gap-1.5 px-3 py-2 bg-gray-900 hover:bg-black text-white rounded-lg text-xs font-semibold transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak
                        </button>
                    </td>
                </tr>
                @endif
                @empty
                <tr id="emptyVerifiedRow">
                    <td colspan="11" class="px-6 py-12 text-center text-gray-400 italic">
                        Belum ada transaksi terverifikasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Footer: Entry count + Pagination + Print -->
    <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="text-sm text-gray-500" id="verifiedInfo">Menampilkan <span id="showingCount">0</span> dari <span id="totalCount">{{ $verifiedOrdersList->count() }}</span> transaksi</p>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-1" id="paginationControls">
            </div>
            <button onclick="printReport()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Laporan
            </button>
        </div>
    </div>
</div>
<div id="verifyModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeVerifyModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all scale-95 opacity-0" id="verifyModalContent">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-orange-100 mb-5">
                <svg class="h-8 w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Konfirmasi Verifikasi</h3>
            <p class="text-gray-600 mb-8">Pastikan pembayaran sudah diselesaikan sebelum Anda memverifikasi transaksi ini.</p>
            <div class="flex gap-3 justify-center">
                <button onclick="closeVerifyModal()" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition">
                    Batal
                </button>
                <button onclick="submitVerify()" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition">
                    Ya, Verifikasi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Pembatalan -->
<div id="cancelModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeCancelModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all scale-95 opacity-0" id="cancelModalContent">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Batalkan Transaksi</h3>
            <p class="text-gray-600 mb-8">Apakah Anda yakin untuk membatalkan transaksi ini?</p>
            <div class="flex gap-3 justify-center">
                <button onclick="closeCancelModal()" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition">
                    Kembali
                </button>
                <button onclick="submitCancel()" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition">
                    Ya, Batalkan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentVerifyOrderId = null;
    let currentCancelOrderId = null;

    function openVerifyModal(orderId) {
        currentVerifyOrderId = orderId;
        const modal = document.getElementById('verifyModal');
        const content = document.getElementById('verifyModalContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeVerifyModal() {
        const modal = document.getElementById('verifyModal');
        const content = document.getElementById('verifyModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 200);
        currentVerifyOrderId = null;
    }

    function submitVerify() {
        if (currentVerifyOrderId) {
            document.getElementById('verify-form-' + currentVerifyOrderId).submit();
        }
    }

    function openCancelModal(orderId) {
        currentCancelOrderId = orderId;
        const modal = document.getElementById('cancelModal');
        const content = document.getElementById('cancelModalContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeCancelModal() {
        const modal = document.getElementById('cancelModal');
        const content = document.getElementById('cancelModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 200);
        currentCancelOrderId = null;
    }

    function submitCancel() {
        if (currentCancelOrderId) {
            document.getElementById('cancel-form-' + currentCancelOrderId).submit();
        }
    }

    // ===== DataTable: Search, Date Filter, Pagination =====
    const ITEMS_PER_PAGE = 10;
    let currentPage = 1;
    let filteredRows = [];

    function filterVerifiedTable() {
        const searchVal = document.getElementById('searchVerified').value.toLowerCase();
        const dateFrom = document.getElementById('dateFrom').value;
        const dateTo = document.getElementById('dateTo').value;
        const rows = document.querySelectorAll('.verified-row');

        filteredRows = [];

        rows.forEach(row => {
            const searchData = row.getAttribute('data-search');
            const rowDate = row.getAttribute('data-date');

            let matchSearch = !searchVal || searchData.includes(searchVal);
            let matchDate = true;

            if (dateFrom && rowDate < dateFrom) matchDate = false;
            if (dateTo && rowDate > dateTo) matchDate = false;

            if (matchSearch && matchDate) {
                filteredRows.push(row);
            }
        });

        currentPage = 1;
        renderPage();
    }

    function renderPage() {
        const rows = document.querySelectorAll('.verified-row');
        const totalFiltered = filteredRows.length;
        const totalPages = Math.max(1, Math.ceil(totalFiltered / ITEMS_PER_PAGE));
        const start = (currentPage - 1) * ITEMS_PER_PAGE;
        const end = start + ITEMS_PER_PAGE;

        // Hide all rows first
        rows.forEach(row => row.style.display = 'none');

        // Show only filtered rows for current page
        filteredRows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = '';
                row.querySelector('.row-number').textContent = index + 1;
            }
        });

        // Update info
        const showingCount = Math.min(totalFiltered, end) - start;
        document.getElementById('showingCount').textContent = totalFiltered === 0 ? '0' : `${start + 1}-${Math.min(end, totalFiltered)}`;
        document.getElementById('totalCount').textContent = totalFiltered;

        // Render pagination
        const controls = document.getElementById('paginationControls');
        controls.innerHTML = '';

        if (totalPages <= 1) return;

        // Prev button
        const prevBtn = document.createElement('button');
        prevBtn.innerHTML = '&laquo;';
        prevBtn.className = `px-3 py-1.5 text-sm rounded-lg transition ${currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'}`;
        prevBtn.disabled = currentPage === 1;
        prevBtn.onclick = () => { if (currentPage > 1) { currentPage--; renderPage(); } };
        controls.appendChild(prevBtn);

        // Page buttons
        for (let i = 1; i <= totalPages; i++) {
            if (totalPages > 7 && i > 3 && i < totalPages - 2 && Math.abs(i - currentPage) > 1) {
                if (i === 4 || i === totalPages - 3) {
                    const dots = document.createElement('span');
                    dots.textContent = '...';
                    dots.className = 'px-2 py-1.5 text-sm text-gray-400';
                    controls.appendChild(dots);
                }
                continue;
            }
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.className = `px-3 py-1.5 text-sm rounded-lg transition ${i === currentPage ? 'bg-blue-600 text-white font-bold' : 'text-gray-700 hover:bg-gray-100'}`;
            btn.onclick = () => { currentPage = i; renderPage(); };
            controls.appendChild(btn);
        }

        // Next button
        const nextBtn = document.createElement('button');
        nextBtn.innerHTML = '&raquo;';
        nextBtn.className = `px-3 py-1.5 text-sm rounded-lg transition ${currentPage === totalPages ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'}`;
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.onclick = () => { if (currentPage < totalPages) { currentPage++; renderPage(); } };
        controls.appendChild(nextBtn);
    }

    // Initialize Flatpickr & default date to today
    let fpFrom, fpTo;
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date();

        fpFrom = flatpickr('#dateFrom', {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'd M Y',
            defaultDate: today,
            disableMobile: true,
            onChange: function() { filterVerifiedTable(); }
        });

        fpTo = flatpickr('#dateTo', {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'd M Y',
            defaultDate: today,
            disableMobile: true,
            onChange: function() { filterVerifiedTable(); }
        });

        filterVerifiedTable();
    });

    function resetDateFilter() {
        fpFrom.clear();
        fpTo.clear();
        filterVerifiedTable();
    }

    // ===== Print Report =====
    function printReport() {
        const dateFrom = document.getElementById('dateFrom').value;
        const dateTo = document.getElementById('dateTo').value;
        let periodLabel = 'Semua Periode';
        if (dateFrom && dateTo) {
            periodLabel = formatDateID(dateFrom) + ' - ' + formatDateID(dateTo);
        } else if (dateFrom) {
            periodLabel = 'Mulai ' + formatDateID(dateFrom);
        } else if (dateTo) {
            periodLabel = 'Sampai ' + formatDateID(dateTo);
        }

        let totalItems = 0;
        let totalRevenue = 0;
        let totalBuyers = 0;
        let tableRows = '';

        filteredRows.forEach((row, idx) => {
            const product = row.getAttribute('data-product-name');
            const customer = row.getAttribute('data-customer-name');
            const phone = row.getAttribute('data-customer-phone');
            const price = parseInt(row.getAttribute('data-price-raw')) || 0;
            const qty = parseInt(row.getAttribute('data-quantity')) || 1;
            const total = parseInt(row.getAttribute('data-total')) || price;
            const date = row.getAttribute('data-order-date');

            totalItems += qty;
            totalRevenue += total;
            totalBuyers++;

            tableRows += '<tr>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px;text-align:center">' + (idx + 1) + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px">' + product + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px">' + customer + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px">' + phone + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px;text-align:right">Rp ' + price.toLocaleString('id-ID') + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px;text-align:center">' + qty + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px;text-align:right;font-weight:bold">Rp ' + total.toLocaleString('id-ID') + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px;text-align:center">' + date + '</td>';
            tableRows += '</tr>';
        });

        const w = window.open('', '_blank');
        const d = w.document;
        d.open();
        d.write('<!DOCTYPE html><html><head><meta charset="utf-8">');
        d.write('<title>Laporan Transaksi - LF Catalog<' + '/title>');
        d.write('<' + 'style>');
        d.write('@page{margin:15mm}');
        d.write('*{margin:0;padding:0;box-sizing:border-box}');
        d.write('body{font-family:Arial,sans-serif;font-size:12px;color:#333}');
        d.write('.header{text-align:center;margin-bottom:20px;border-bottom:2px solid #333;padding-bottom:15px}');
        d.write('.header h1{font-size:20px;margin-bottom:4px}');
        d.write('.header p{font-size:12px;color:#666}');
        d.write('table{width:100%;border-collapse:collapse;margin-top:10px}');
        d.write('th{background:#f5f5f5;border:1px solid #ddd;padding:8px 10px;text-align:left;font-size:11px;text-transform:uppercase}');
        d.write('td{font-size:11px}');
        d.write('.summary{margin-top:25px;border-top:2px solid #333;padding-top:15px}');
        d.write('.summary-grid{display:flex;justify-content:space-between;gap:20px}');
        d.write('.summary-item{text-align:center;flex:1;padding:12px;border:1px solid #ddd;border-radius:8px}');
        d.write('.summary-item .label{font-size:10px;text-transform:uppercase;color:#888;margin-bottom:4px}');
        d.write('.summary-item .value{font-size:18px;font-weight:bold}');
        d.write('.footer{text-align:center;margin-top:30px;font-size:10px;color:#aaa}');
        d.write('<' + '/style><' + '/head><body>');
        d.write('<div class="header">');
        d.write('<h1>LF CATALOG</h1>');
        d.write('<p>Laporan Transaksi Terverifikasi</p>');
        d.write('<p style="margin-top:6px;font-weight:bold">Periode: ' + periodLabel + '</p>');
        d.write('</div>');
        d.write('<table>');
        d.write('<thead><tr>');
        d.write('<th style="text-align:center;width:40px">No</th>');
        d.write('<th>Produk</th>');
        d.write('<th>Pembeli</th>');
        d.write('<th>Telepon</th>');
        d.write('<th style="text-align:right">Harga</th>');
        d.write('<th style="text-align:center">Jumlah</th>');
        d.write('<th style="text-align:right">Total</th>');
        d.write('<th style="text-align:center">Tanggal</th>');
        d.write('</tr></thead>');;
        d.write('<tbody>' + tableRows + '</tbody>');
        d.write('</table>');
        d.write('<div class="summary">');
        d.write('<div class="summary-grid">');
        d.write('<div class="summary-item"><div class="label">Total Barang Laku</div><div class="value">' + totalItems + '</div></div>');
        d.write('<div class="summary-item"><div class="label">Total Pendapatan</div><div class="value">Rp ' + totalRevenue.toLocaleString('id-ID') + '</div></div>');
        d.write('<div class="summary-item"><div class="label">Jumlah Pembeli</div><div class="value">' + totalBuyers + '</div></div>');
        d.write('</div></div>');
        d.write('<div class="footer"><p>Dicetak pada: ' + new Date().toLocaleString('id-ID') + '</p><p>LF Catalog &copy; 2026</p></div>');
        d.write('<' + 'script>window.onload=function(){window.print()}<' + '/script>');
        d.write('<' + '/body><' + '/html>');
        d.close();
    }

    function formatDateID(dateStr) {
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
        const parts = dateStr.split('-');
        return parseInt(parts[2]) + ' ' + months[parseInt(parts[1]) - 1] + ' ' + parts[0];
    }

    // ===== Print Receipt (Thermal 58mm) =====
    function printReceipt(btn) {
        const data = {
            id: btn.getAttribute('data-id'),
            name: btn.getAttribute('data-name'),
            phone: btn.getAttribute('data-phone'),
            address: btn.getAttribute('data-address'),
            product: btn.getAttribute('data-product'),
            price: btn.getAttribute('data-price'),
            quantity: btn.getAttribute('data-quantity') || '1',
            total: btn.getAttribute('data-total'),
            date: btn.getAttribute('data-date'),
        };

        const receiptWindow = window.open('', '_blank', 'width=400,height=600');
        const doc = receiptWindow.document;
        doc.open();
        doc.write('<!DOCTYPE html><html><head><meta charset="utf-8"><title>Struk ' + data.id + '<' + '/title>');
        doc.write('<' + 'style>');
        doc.write('@page{margin:0;size:58mm auto}');
        doc.write('*{margin:0;padding:0;box-sizing:border-box}');
        doc.write('body{font-family:"Courier New",monospace;font-size:12px;width:58mm;padding:8px;color:#000}');
        doc.write('.center{text-align:center}.bold{font-weight:bold}');
        doc.write('.divider{border-top:1px dashed #000;margin:6px 0}');
        doc.write('.row{display:flex;justify-content:space-between;margin:2px 0}');
        doc.write('.label{color:#555;font-size:10px;text-transform:uppercase}');
        doc.write('.value{font-size:11px;word-wrap:break-word}');
        doc.write('.total-row{display:flex;justify-content:space-between;font-weight:bold;font-size:14px;margin:4px 0}');
        doc.write('h2{font-size:16px;margin-bottom:2px}');
        doc.write('.footer{font-size:9px;color:#888;margin-top:8px}');
        doc.write('<' + '/style><' + '/head><body>');
        doc.write('<div class="center"><h2 class="bold">LF CATALOG</h2><p style="font-size:10px;color:#666">Struk Transaksi</p></div>');
        doc.write('<div class="divider"></div>');
        doc.write('<div class="row"><span>No. Transaksi</span><span class="bold">' + data.id + '</span></div>');
        doc.write('<div class="row"><span>Tanggal</span><span>' + data.date + '</span></div>');
        doc.write('<div class="divider"></div>');
        doc.write('<p class="label">Pelanggan</p>');
        doc.write('<p class="value bold">' + data.name + '</p>');
        doc.write('<p class="value">' + data.phone + '</p>');
        doc.write('<p class="value" style="font-size:10px">' + data.address + '</p>');
        doc.write('<div class="divider"></div>');
        doc.write('<p class="label">Produk</p>');
        doc.write('<p class="value bold">' + data.product + '</p>');
        doc.write('<div class="row"><span>Harga</span><span>' + data.price + '</span></div>');
        doc.write('<div class="row"><span>Jumlah</span><span>' + data.quantity + '</span></div>');
        doc.write('<div class="divider"></div>');
        doc.write('<div class="total-row"><span>TOTAL</span><span>' + data.total + '</span></div>');
        doc.write('<div class="divider"></div>');
        doc.write('<div class="center footer"><p>Terima kasih atas pembelian Anda!</p><p style="margin-top:4px">\u2014 LF Catalog \u2014</p></div>');
        doc.write('<' + 'script>window.onload=function(){window.print()}<' + '/script>');
        doc.write('<' + '/body><' + '/html>');
        doc.close();
    }
</script>
@endsection
