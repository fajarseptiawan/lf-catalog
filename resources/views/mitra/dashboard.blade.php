@extends('layouts.mitra')

@section('title', 'Dashboard - ' . ($mitra->store_name ?? 'Mitra'))

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Selamat datang, {{ Auth::user()->name }}!</h1>
    <p class="text-gray-500 mt-1">Dashboard mitra <span class="font-semibold text-gray-700">{{ $mitra->store_name }}</span></p>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
    {{-- Jumlah Produk --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Jumlah Produk</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalProducts }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Total Stok --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Stok</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalStock }}</p>
                <p class="text-xs text-gray-400 mt-1">Unit tersedia</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Jumlah Order --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Jumlah Pesanan</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalOrders }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Total Pendapatan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">Dari pesanan lunas</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Total Pengeluaran Belanja --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pengeluaran</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format($totalExpenditure, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">Belanja stok produk</p>
            </div>
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

{{-- Recent Orders --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h2 class="text-lg font-bold text-gray-900">Pesanan Terbaru</h2>
        <a href="{{ route('mitra.orders') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentOrders as $order)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm font-mono text-gray-500">#{{ $order->id }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $order->product->name ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ $order->customer_name }}</div>
                        <div class="text-xs text-gray-400">{{ $order->customer_phone }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $order->quantity }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        Rp {{ number_format(($order->product->price ?? 0) * $order->quantity, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($order->status === 'pending')
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs font-semibold border border-yellow-200">Pending</span>
                        @elseif($order->status === 'paid')
                            <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-semibold border border-green-200">Lunas</span>
                        @else
                            <span class="px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-semibold border border-red-200">{{ ucfirst($order->status) }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 italic">
                        Belum ada pesanan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
