@extends('layouts.app')

@section('title', 'Pesanan Berhasil - LF Catalog')

@section('content')
<section class="max-w-2xl mx-auto px-4 py-8 mt-14">
    {{-- Success Icon --}}
    <div class="text-center mb-8">
        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Pesanan Berhasil!</h1>
        <p class="text-gray-400 mt-2">Pesanan Anda telah diterima dan sedang diproses</p>
    </div>

    {{-- Invoice Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div class="p-5 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Invoice</p>
                <p class="text-lg font-bold text-gray-900 font-mono">{{ $order->invoice_code }}</p>
            </div>
            <span class="px-3 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs font-semibold border border-yellow-200">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        {{-- Customer Info --}}
        <div class="p-5 border-b border-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Nama</p>
                    <p class="font-semibold text-gray-900">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">WhatsApp</p>
                    <p class="font-semibold text-gray-900">{{ $order->customer_phone }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Alamat</p>
                    <p class="font-semibold text-gray-900">{{ $order->address }}</p>
                </div>
                @if($order->notes)
                <div class="sm:col-span-2">
                    <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Catatan</p>
                    <p class="text-gray-600">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Order Items --}}
        <div class="divide-y divide-gray-50">
            @foreach($order->items as $item)
            <div class="p-4 flex items-center gap-4">
                @if($item->product && $item->product->image)
                    <img src="{{ asset($item->product->image) }}" alt="" class="w-12 h-12 object-contain rounded-xl bg-gray-50 p-1 border border-gray-100 shrink-0">
                @else
                    <div class="w-12 h-12 rounded-xl bg-gray-100 shrink-0"></div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900 text-sm truncate">{{ $item->product->name ?? 'Produk' }}</p>
                    <p class="text-xs text-gray-400">Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}</p>
                </div>
                <p class="font-bold text-gray-900 text-sm shrink-0">
                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                </p>
            </div>
            @endforeach
        </div>

        {{-- Total --}}
        <div class="p-5 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
            <span class="font-semibold text-gray-600">Total Pembayaran</span>
            <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex flex-col gap-3">
        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer"
            class="w-full flex items-center justify-center bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-8 rounded-full transition duration-300 shadow-lg text-lg">
            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            Konfirmasi via WhatsApp
        </a>
        <p class="text-center text-sm text-gray-400">Klik tombol di atas untuk mengirim detail pesanan ke admin</p>
        <a href="{{ route('home') }}" class="w-full flex items-center justify-center bg-gray-900 hover:bg-gray-800 text-white font-bold py-4 px-8 rounded-full transition duration-300 shadow-lg text-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Kembali ke Beranda
        </a>
    </div>
</section>

@push('js')
<script>
    // Clear cart after successful checkout
    document.addEventListener('DOMContentLoaded', function() {
        LFCart.clear();
    });
</script>
@endpush
@endsection
