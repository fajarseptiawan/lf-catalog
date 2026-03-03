@extends('layouts.app')

@section('title', ucfirst($category) . ' - LF Catalog')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-8">
        <nav class="text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-gray-900">Home</a> /
            <span class="text-gray-900">{{ ucfirst($category) }}</span>
        </nav>
        <h1 class="text-3xl font-bold text-gray-900">Jelajahi {{ ucfirst($category) }}</h1>
    </div>

    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 group cursor-pointer" onclick="window.location='{{ route('product.detail', $product->slug) }}'">
                    <div class="relative aspect-square bg-gray-50 flex items-center justify-center p-6">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="max-w-full h-full object-contain transition-transform duration-500 group-hover:scale-110">
                        @if($product->stock < 1)
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center rounded-t-xl">
                            <span class="text-white text-2xl font-bold tracking-wider">HABIS</span>
                        </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $product->name }}</h3>
                        <p class="text-orange-600 font-bold mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <button class="w-full border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white py-2 rounded-full transition duration-300">Lihat Detail</button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-2xl shadow-sm">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <p class="text-xl text-gray-500 font-medium">Belum ada produk untuk kategori ini.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block text-orange-600 hover:underline">Kembali ke Beranda</a>
        </div>
    @endif
</section>
@endsection
