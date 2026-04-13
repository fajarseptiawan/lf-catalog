@extends('layouts.app')

@section('title', 'LF Catalog')

@section('content')

    <section class="w-full mx-auto px-4 pt-20 py-6 border-b border-gray-300">
        <div id="controls-carousel" class="relative w-full max-w-7xl mx-auto">
            <div class="relative h-48 sm:h-56 md:h-64 lg:h-80 xl:h-96 overflow-hidden rounded-lg">
                <div class="w-full h-full">
                    <img src="{{ asset('img/tes.png') }}" class="w-full h-full object-cover" alt="...">
                </div>
            </div>
        </div>
    </section>




    <section class="pt-20 pb-10 text-center bg-white border-b border-gray-300">
        <div class="max-w-xl mx-auto px-4">
            <span class="text-orange-600 font-bold text-sm tracking-widest uppercase mb-2 block">New</span>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Kaos Kaki Futsal
            </h1>
            <p class="text-md md:text-2xl text-gray-800 mb-2">
                SUPER GRIP
            </p>
            <p class="text-sm text-gray-500 mb-8">
                Harga Mulai Dari Rp{{ number_format($products->min('price'), 0, ',', '.') }}
            </p>

            <div class="flex justify-center items-center gap-6 mb-12">
                <a href="#" class="text-blue-600 hover:underline flex items-center font-medium text-lg">
                    Lebih lanjut <span class="ml-1">›</span>
                </a>
                <button
                    class="bg-blue-600 text-white px-8 py-3 rounded-full font-medium hover:bg-blue-700 transition-colors text-lg">
                    Beli sekarang
                </button>
            </div>

            <div class="reveal-left opacity-0 translate-y-20 transition-all duration-1000 ease-out">
                <img src="{{ asset('img/tes.png') }}" class="mx-auto max-w-4xl w-full" alt="Kaos Kaki Futsal">
            </div>
        </div>
    </section>


    @foreach ($products as $product)
        <section class="py-20 bg-white border-b border-gray-300 cursor-pointer"
            onclick="window.location='{{ route('product.detail', $product->slug) }}'">
            <div class="max-w-7xl px-4 mx-auto">
                <div class="grid gap-8 md:grid-cols-2 items-center">

                    <!-- Bagian Tulisan (Kiri) -->
                    <div
                        class="order-2 md:order-1 text-center md:text-left reveal-left opacity-0 -translate-x-20 transition-all duration-1000 ease-out">
                        <h3 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h3>
                        <p class="mt-2 text-gray-600">{{ $product->description }}</p>
                        <p class="mt-1 text-sm text-gray-500">Harga Rp
                            {{ number_format($product->price, 0, ',', '.') }}</p>
                        <div class="mt-6">
                            <span
                                class="px-6 py-2 text-sm font-medium text-blue-600 border border-blue-600 rounded-full hover:bg-blue-50 transition">
                                Lihat Detail
                            </span>
                        </div>
                    </div>

                    <!-- Bagian Gambar (Kanan) -->
                    <div
                        class="order-1 md:order-2 flex justify-center reveal-left opacity-0 translate-x-20 transition-all duration-1000 ease-out">
                        <img src="{{ asset($product->image) }}" class="h-40 md:h-48 lg:h-56 object-contain"
                            alt="{{ $product->name }}">
                    </div>

                </div>
            </div>
        </section>
    @endforeach




    @push('js')
        <script src="{{ asset('assets/kaoskakifs.js') }}"></script>
    @endpush
@endsection
