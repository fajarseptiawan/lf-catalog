@extends('layouts.app')

@section('title', 'Keranjang - LF Catalog')

@section('content')
<section class="max-w-4xl mx-auto px-4 py-8 mt-14">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Keranjang</h1>
            <p class="text-gray-400 mt-1" id="cart-count-text">0 item</p>
        </div>
        <button onclick="clearCart()" id="btn-clear" class="hidden text-sm text-red-500 hover:text-red-700 font-medium transition">
            Hapus Semua
        </button>
    </div>

    <!-- Empty State -->
    <div id="cart-empty" class="hidden text-center py-20">
        <svg class="w-20 h-20 mx-auto text-gray-200 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path>
        </svg>
        <p class="text-gray-400 text-lg mb-6">Keranjang Anda masih kosong</p>
        <a href="{{ route('home') }}" class="inline-flex items-center bg-gray-900 text-white px-8 py-3 rounded-full font-semibold hover:bg-gray-800 transition shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Belanja Sekarang
        </a>
    </div>

    <!-- Cart Items -->
    <div id="cart-items" class="space-y-4 mb-8"></div>

    <!-- Summary -->
    <div id="cart-summary" class="hidden bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky bottom-4">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-sm text-gray-400">Total Belanja</p>
                <p class="text-3xl font-bold text-gray-900" id="cart-total">Rp 0</p>
                <p class="text-xs text-gray-400 mt-1"><span id="cart-total-items">0</span> item</p>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition whitespace-nowrap">← Belanja lagi</a>
                <a href="{{ route('checkout') }}" class="flex-1 sm:flex-none flex items-center justify-center bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-full transition shadow-lg">
                    Checkout
                </a>
            </div>
        </div>
    </div>
</section>

@push('js')
<script>
    function renderCart() {
        const items = LFCart.getAll();
        const container = document.getElementById('cart-items');
        const emptyState = document.getElementById('cart-empty');
        const summary = document.getElementById('cart-summary');
        const btnClear = document.getElementById('btn-clear');
        const countText = document.getElementById('cart-count-text');

        if (items.length === 0) {
            container.innerHTML = '';
            emptyState.classList.remove('hidden');
            summary.classList.add('hidden');
            btnClear.classList.add('hidden');
            countText.textContent = '0 item';
            return;
        }

        emptyState.classList.add('hidden');
        summary.classList.remove('hidden');
        btnClear.classList.remove('hidden');

        const totalItems = LFCart.totalItems();
        countText.textContent = totalItems + ' item';
        document.getElementById('cart-total').textContent = LFCart.formatRupiah(LFCart.totalPrice());
        document.getElementById('cart-total-items').textContent = totalItems;

        container.innerHTML = items.map(item => `
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex gap-4 items-start transition hover:shadow-md">
                <a href="/product/${item.slug}" class="shrink-0">
                    <img src="${item.image}" alt="${item.name}" class="w-20 h-20 sm:w-24 sm:h-24 object-contain rounded-xl bg-gray-50 p-2 border border-gray-100">
                </a>
                <div class="flex-1 min-w-0">
                    <a href="/product/${item.slug}" class="font-semibold text-gray-900 hover:text-blue-600 transition block truncate">${item.name}</a>
                    <p class="text-xs text-gray-400 mt-0.5">${item.category ? item.category.charAt(0).toUpperCase() + item.category.slice(1) : ''}</p>
                    <p class="text-lg font-bold text-gray-900 mt-1">${LFCart.formatRupiah(item.price)}</p>
                    <div class="flex items-center justify-between mt-3">
                        <div class="inline-flex items-center border border-gray-200 rounded-xl overflow-hidden">
                            <button onclick="updateQty(${item.id}, ${item.qty - 1})" class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition text-lg">−</button>
                            <span class="w-10 h-9 flex items-center justify-center text-sm font-semibold border-x border-gray-200">${item.qty}</span>
                            <button onclick="updateQty(${item.id}, ${item.qty + 1})" class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition text-lg" ${item.qty >= item.stock ? 'disabled' : ''}>+</button>
                        </div>
                        <div class="flex items-center gap-3">
                            <p class="text-sm font-semibold text-gray-600">${LFCart.formatRupiah(item.price * item.qty)}</p>
                            <button onclick="removeItem(${item.id})" class="text-gray-300 hover:text-red-500 transition p-1" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function updateQty(id, qty) {
        if (qty < 1) {
            removeItem(id);
            return;
        }
        LFCart.updateQty(id, qty);
        renderCart();
    }

    function removeItem(id) {
        LFCart.remove(id);
        renderCart();
    }

    function clearCart() {
        if (confirm('Hapus semua item dari keranjang?')) {
            LFCart.clear();
            renderCart();
        }
    }

    document.addEventListener('DOMContentLoaded', renderCart);
</script>
@endpush
@endsection
