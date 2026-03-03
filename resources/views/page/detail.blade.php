@extends('layouts.app')

@section('title', $product->name . ' - LF Catalog')

@section('content')
@php
    $allImages = [];
    if ($product->images && is_array($product->images)) {
        $allImages = $product->images;
    }
    if ($product->image && !in_array($product->image, $allImages)) {
        array_unshift($allImages, $product->image);
    }
    if (empty($allImages)) {
        $allImages = ['img/tes.png'];
    }
@endphp

<section class="max-w-4xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-gray-900 transition">Home</a>
        <span class="mx-1">/</span>
        <a href="{{ route('category', $product->category) }}" class="hover:text-gray-900 transition">{{ ucfirst($product->category) }}</a>
        <span class="mx-1">/</span>
        <span class="text-gray-600">{{ $product->name }}</span>
    </nav>

    <!-- Image Slider -->
    <div class="relative rounded-2xl overflow-hidden mb-8" id="sliderContainer">
        <div class="relative w-full" style="padding-bottom: 75%;">
            @foreach($allImages as $idx => $img)
            <div class="slider-slide absolute inset-0 flex items-center justify-center transition-opacity duration-500 {{ $idx === 0 ? 'opacity-100' : 'opacity-0' }}" data-index="{{ $idx }}">
                <img src="{{ asset($img) }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain p-6">
            </div>
            @endforeach
            @if($product->stock < 1)
            <div class="absolute inset-0 bg-black/50 flex items-center justify-center z-10">
                <span class="text-white text-4xl font-bold tracking-widest">HABIS</span>
            </div>
            @endif
        </div>

        @if(count($allImages) > 1)
        <!-- Prev/Next -->
        <button onclick="slideNav(-1)" class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white shadow-lg rounded-full w-10 h-10 flex items-center justify-center transition">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button onclick="slideNav(1)" class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white shadow-lg rounded-full w-10 h-10 flex items-center justify-center transition">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
        <!-- Dots -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
            @foreach($allImages as $idx => $img)
            <button onclick="goToSlide({{ $idx }})" class="slider-dot w-2.5 h-2.5 rounded-full transition {{ $idx === 0 ? 'bg-gray-800 scale-110' : 'bg-gray-300' }}" data-index="{{ $idx }}"></button>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Thumbnails -->
    @if(count($allImages) > 1)
    <div class="flex gap-3 mb-8 overflow-x-auto pb-2">
        @foreach($allImages as $idx => $img)
        <button onclick="goToSlide({{ $idx }})" class="thumb-btn flex-shrink-0 w-16 h-16 rounded-xl border-2 overflow-hidden transition {{ $idx === 0 ? 'border-gray-900' : 'border-gray-200 hover:border-gray-400' }}" data-index="{{ $idx }}">
            <img src="{{ asset($img) }}" alt="" class="w-full h-full object-contain p-1">
        </button>
        @endforeach
    </div>
    @endif

    <!-- Product Title -->
    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">{{ $product->name }}</h1>

    <!-- Price -->
    <p class="text-2xl font-semibold text-gray-900 mt-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

    <!-- Stock Info -->
    <div class="flex items-center gap-2 mt-2">
        @if($product->stock > 0)
            <span class="text-sm text-green-600 font-medium">Stok tersedia: {{ $product->stock }}</span>
        @else
            <span class="text-sm text-red-600 font-medium">Stok habis</span>
        @endif
    </div>

    <!-- Quantity Selector -->
    <div class="mt-6">
        <p class="text-base font-semibold text-gray-900 mb-3">Jumlah</p>
        <div class="inline-flex items-center border border-gray-300 rounded-xl overflow-hidden">
            <button onclick="changeQty(-1)" class="w-12 h-12 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition text-xl">−</button>
            <input type="number" id="qty" value="1" min="1" max="{{ $product->stock }}" class="w-16 h-12 text-center text-lg font-semibold border-x border-gray-300 outline-none" readonly>
            <button onclick="changeQty(1)" class="w-12 h-12 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition text-xl">+</button>
        </div>
    </div>

    <!-- Order Button -->
    <div class="mt-8">
        <button onclick="openOrderModal()" class="w-full flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-8 rounded-full transition duration-300 shadow-lg text-lg {{ $product->stock < 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $product->stock < 1 ? 'disabled' : '' }}>
            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
            Pesan via WhatsApp
        </button>
    </div>

    <!-- Full Divider -->
    <hr class="my-10 border-gray-200">

    <!-- Description -->
    <div>
        <h2 class="text-xl font-bold text-gray-900 mb-4">Deskripsi</h2>
        <div class="text-gray-600 leading-relaxed whitespace-pre-line text-base">{{ $product->description }}</div>
    </div>

    @if($product->features && count($product->features) > 0)
    <div class="mt-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Keunggulan</h2>
        <ul class="space-y-2">
            @foreach($product->features as $feature)
            <li class="flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-gray-600">{{ $feature }}</span>
            </li>
            @endforeach
        </ul>
    </div>
    @endif
    <hr class="my-10 border-gray-200">
</section>

<!-- Order Modal -->
<div id="orderModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeOrderModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all scale-95 opacity-0" id="orderModalContent">
        <button onclick="closeOrderModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
            <img src="{{ asset($allImages[0]) }}" alt="" class="w-16 h-16 object-contain bg-gray-50 rounded-xl p-2">
            <div>
                <h3 class="font-bold text-gray-900">{{ $product->name }}</h3>
                <p class="text-sm text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }} × <span id="modalQty">1</span></p>
            </div>
        </div>

        <form action="{{ route('order.store', $product->id) }}" method="POST" class="space-y-4" id="orderForm">
            @csrf
            <input type="hidden" name="quantity" id="orderQuantity" value="1">
            <div>
                <label for="customer_name" class="block mb-2 text-sm font-semibold text-gray-900">Nama Lengkap</label>
                <input type="text" name="customer_name" id="customer_name" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-green-200 focus:border-green-500 block w-full p-3 outline-none transition" placeholder="Contoh: Budi Santoso" required>
            </div>
            <div>
                <label for="customer_phone" class="block mb-2 text-sm font-semibold text-gray-900">Nomor WhatsApp</label>
                <input type="tel" name="customer_phone" id="customer_phone" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-green-200 focus:border-green-500 block w-full p-3 outline-none transition" placeholder="Contoh: 08123456789" required>
            </div>
            <div>
                <label for="address" class="block mb-2 text-sm font-semibold text-gray-900">Alamat Lengkap</label>
                <textarea name="address" id="address" rows="3" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-200 focus:border-green-500 outline-none transition" placeholder="Jl. Sudirman No. 123, Jakarta..." required></textarea>
            </div>
            <button type="submit" class="w-full flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-8 rounded-full transition duration-300 shadow-lg mt-2">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Konfirmasi Pesanan
            </button>
        </form>
    </div>
</div>

<script>
    // ===== Image Slider =====
    let currentSlide = 0;
    const totalSlides = {{ count($allImages) }};

    function goToSlide(idx) {
        const slides = document.querySelectorAll('.slider-slide');
        const dots = document.querySelectorAll('.slider-dot');
        const thumbs = document.querySelectorAll('.thumb-btn');

        slides.forEach(s => s.classList.replace('opacity-100', 'opacity-0'));
        dots.forEach(d => { d.classList.remove('bg-gray-800', 'scale-110'); d.classList.add('bg-gray-300'); });
        thumbs.forEach(t => { t.classList.remove('border-gray-900'); t.classList.add('border-gray-200'); });

        slides[idx].classList.replace('opacity-0', 'opacity-100');
        if (dots[idx]) { dots[idx].classList.remove('bg-gray-300'); dots[idx].classList.add('bg-gray-800', 'scale-110'); }
        if (thumbs[idx]) { thumbs[idx].classList.remove('border-gray-200'); thumbs[idx].classList.add('border-gray-900'); }

        currentSlide = idx;
    }

    function slideNav(dir) {
        let next = currentSlide + dir;
        if (next < 0) next = totalSlides - 1;
        if (next >= totalSlides) next = 0;
        goToSlide(next);
    }

    // ===== Quantity =====
    function changeQty(delta) {
        const input = document.getElementById('qty');
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        if (val > parseInt(input.max)) val = parseInt(input.max);
        input.value = val;
    }

    // ===== Order Modal =====
    function openOrderModal() {
        const qty = document.getElementById('qty').value;
        document.getElementById('modalQty').textContent = qty;
        document.getElementById('orderQuantity').value = qty;

        const modal = document.getElementById('orderModal');
        const content = document.getElementById('orderModalContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeOrderModal() {
        const modal = document.getElementById('orderModal');
        const content = document.getElementById('orderModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 200);
    }
</script>
@endsection
