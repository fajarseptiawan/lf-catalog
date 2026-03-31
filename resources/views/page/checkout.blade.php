@extends('layouts.app')

@section('title', 'Checkout - LF Catalog')

@section('content')
<section class="max-w-3xl mx-auto px-4 py-8 mt-14">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Checkout</h1>
    <p class="text-gray-400 mb-8">Lengkapi data Anda untuk menyelesaikan pesanan</p>

    @if($errors->any())
    <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 border border-red-100 text-sm">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    {{-- Order Summary (rendered by JS from localStorage) --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-6 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <h2 class="font-bold text-gray-900">Ringkasan Pesanan</h2>
        </div>
        <div id="checkout-items" class="divide-y divide-gray-50"></div>
        <div class="p-5 bg-gray-50 flex items-center justify-between">
            <span class="font-semibold text-gray-600">Total</span>
            <span class="text-xl font-bold text-gray-900" id="checkout-total">Rp 0</span>
        </div>
    </div>

    {{-- Checkout Form --}}
    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm" class="space-y-5">
        @csrf
        <input type="hidden" name="items" id="checkoutItems" value="">

        <div>
            <label for="customer_name" class="block mb-2 text-sm font-semibold text-gray-900">Nama Lengkap</label>
            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}"
                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-200 focus:border-blue-500 block w-full p-3 outline-none transition" placeholder="Contoh: Budi Santoso" required>
        </div>

        <div>
            <label for="customer_phone" class="block mb-2 text-sm font-semibold text-gray-900">Nomor WhatsApp</label>
            <input type="tel" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}"
                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-200 focus:border-blue-500 block w-full p-3 outline-none transition" placeholder="Contoh: 08123456789" required>
        </div>

        <div>
            <label for="address" class="block mb-2 text-sm font-semibold text-gray-900">Alamat Lengkap</label>
            <textarea name="address" id="address" rows="3"
                class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition" placeholder="Jl. Sudirman No. 123, Jakarta..." required>{{ old('address') }}</textarea>
        </div>

        <div>
            <label for="notes" class="block mb-2 text-sm font-semibold text-gray-900">Catatan <span class="text-gray-400 font-normal">(opsional)</span></label>
            <textarea name="notes" id="notes" rows="2"
                class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition" placeholder="Warna, ukuran, atau catatan lainnya...">{{ old('notes') }}</textarea>
        </div>

        <button type="submit" id="btn-checkout" disabled
            class="w-full flex items-center justify-center bg-gray-900 hover:bg-gray-800 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-4 px-8 rounded-full transition duration-300 shadow-lg text-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Buat Pesanan
        </button>
    </form>
</section>

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = LFCart.getAll();

        if (items.length === 0) {
            window.location.href = '/cart';
            return;
        }

        // Render order summary
        const container = document.getElementById('checkout-items');
        container.innerHTML = items.map(item => `
            <div class="p-4 flex items-center gap-4">
                <img src="${item.image}" alt="${item.name}" class="w-14 h-14 object-contain rounded-xl bg-gray-50 p-1 border border-gray-100 shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900 text-sm truncate">${item.name}</p>
                    <p class="text-xs text-gray-400">${LFCart.formatRupiah(item.price)} × ${item.qty}</p>
                </div>
                <p class="font-bold text-gray-900 text-sm shrink-0">${LFCart.formatRupiah(item.price * item.qty)}</p>
            </div>
        `).join('');

        document.getElementById('checkout-total').textContent = LFCart.formatRupiah(LFCart.totalPrice());

        // Set items JSON for form submission
        const itemsData = items.map(i => ({ id: i.id, name: i.name, qty: i.qty }));
        document.getElementById('checkoutItems').value = JSON.stringify(itemsData);

        // Enable submit
        document.getElementById('btn-checkout').disabled = false;
    });

    // Clear cart after successful form submission
    document.getElementById('checkoutForm').addEventListener('submit', function() {
        // Cart will be cleared on success page
    });
</script>
@endpush
@endsection
