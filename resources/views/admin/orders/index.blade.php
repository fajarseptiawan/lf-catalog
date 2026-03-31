@extends('layouts.admin')

@section('title', 'Daftar Pesanan - LF Catalog')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Daftar Pesanan</h1>
    <p class="text-gray-500">Kelola pesanan masuk dan verifikasi pembayaran</p>
</div>

    @if(session('success'))
        <div class="bg-green-50 text-green-600 p-4 rounded-xl mb-6 border border-green-100 flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 border border-red-100 flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Filter Bar -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <!-- Status Tabs -->
                <div class="flex items-center gap-1 bg-gray-100 rounded-xl p-1">
                    <button onclick="setStatusFilter('all')" id="tab-all" class="status-tab px-4 py-2 text-sm font-semibold rounded-lg transition bg-white text-gray-900 shadow-sm">
                        Semua
                    </button>
                    <button onclick="setStatusFilter('pending')" id="tab-pending" class="status-tab px-4 py-2 text-sm font-semibold rounded-lg transition text-gray-500 hover:text-gray-700">
                        Pending
                    </button>
                    <button onclick="setStatusFilter('paid')" id="tab-paid" class="status-tab px-4 py-2 text-sm font-semibold rounded-lg transition text-gray-500 hover:text-gray-700">
                        Terverifikasi
                    </button>
                    <button onclick="setStatusFilter('canceled')" id="tab-canceled" class="status-tab px-4 py-2 text-sm font-semibold rounded-lg transition text-gray-500 hover:text-gray-700">
                        Dibatalkan
                    </button>
                </div>
                <!-- Date & Search -->
                <div class="flex flex-col sm:flex-row gap-3 items-end">
                    <!-- Date Filter -->
                    <div class="flex items-center gap-2 bg-gray-50 rounded-2xl px-4 py-2 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-xs font-semibold text-gray-500 uppercase">Dari</span>
                            <input type="text" id="orderDateFrom" class="flatpickr-input px-3 py-1.5 text-sm bg-white border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition cursor-pointer w-32" placeholder="Pilih tanggal" readonly>
                        </div>
                        <span class="text-gray-300 text-lg">→</span>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Sampai</span>
                            <input type="text" id="orderDateTo" class="flatpickr-input px-3 py-1.5 text-sm bg-white border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition cursor-pointer w-32" placeholder="Pilih tanggal" readonly>
                        </div>
                        <button onclick="resetOrderDateFilter()" class="ml-1 p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Reset filter tanggal">
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
                        <input type="text" id="searchOrder" class="pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white outline-none transition w-full sm:w-64" placeholder="Cari nama, produk, telepon..." oninput="filterOrderTable()">
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="orderTable">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Total Harga</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pemesan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="orderTableBody">
                    @forelse($orders as $index => $order)
                    @php
                        $isMulti = $order->items->count() > 0;
                        $firstProduct = $isMulti ? $order->items->first()->product : $order->product;
                        $displayPrice = $isMulti ? $order->items->first()->price : ($order->product->price ?? 0);
                        $displayQty = $isMulti ? $order->items->sum('quantity') : ($order->quantity ?? 1);
                        $displayTotal = $isMulti ? $order->items->sum(fn($i) => $i->price * $i->quantity) : (($order->product->price ?? 0) * ($order->quantity ?? 1));
                    @endphp
                    <tr class="hover:bg-gray-50 transition order-row"
                        data-search="{{ strtolower($order->customer_name . ' ' . $order->customer_phone . ' ' . ($firstProduct->name ?? '') . ' ' . $order->address . ' ' . $order->invoice_code) }}"
                        data-date="{{ $order->created_at->format('Y-m-d') }}"
                        data-status="{{ $order->status }}"
                        data-product-name="{{ $firstProduct->name ?? '-' }}"
                        data-customer-name="{{ $order->customer_name }}"
                        data-customer-phone="{{ $order->customer_phone }}"
                        data-price="{{ $displayPrice }}"
                        data-quantity="{{ $displayQty }}"
                        data-total="{{ $displayTotal }}"
                        data-order-date="{{ $order->created_at->format('d/m/Y H:i') }}">
                        <td class="px-6 py-4 text-sm text-gray-500 order-row-number">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-mono text-sm text-gray-500">
                            {{ $order->invoice_code ? $order->invoice_code : '#' . str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($isMulti)
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset($firstProduct->image ?? 'img/tes.png') }}" alt="" class="w-10 h-10 object-contain bg-gray-50 rounded-lg border border-gray-100 p-1">
                                    <div>
                                        <div class="font-semibold text-gray-900 text-sm">{{ $firstProduct->name ?? '-' }}</div>
                                        @if($order->items->count() > 1)
                                            <div class="text-xs text-blue-500 font-medium">+{{ $order->items->count() - 1 }} produk lain</div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset($order->product->image ?? 'img/tes.png') }}" alt="" class="w-10 h-10 object-contain bg-gray-50 rounded-lg border border-gray-100 p-1">
                                    <div class="font-semibold text-gray-900 text-sm">{{ $order->product->name ?? '-' }}</div>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            Rp {{ number_format($displayPrice, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900 text-center">
                            {{ $displayQty }}
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">
                            Rp {{ number_format($displayTotal, 0, ',', '.') }}
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
                            @if($order->status === 'paid')
                                <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-semibold border border-green-100">LUNAS</span>
                            @elseif($order->status === 'canceled')
                                <span class="px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-semibold border border-red-100">DIBATALKAN</span>
                            @else
                                <span class="px-3 py-1 bg-orange-50 text-orange-700 rounded-full text-xs font-semibold border border-orange-100">PENDING</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            @if($order->status === 'pending')
                                <div class="flex justify-end gap-2">
                                    <form id="verify-form-{{ $order->id }}" action="{{ route('admin.orders.verify', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="button" onclick="openVerifyModal({{ $order->id }})" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                            Verifikasi
                                        </button>
                                    </form>
                                    <form id="cancel-form-{{ $order->id }}" action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="button" onclick="openCancelModal({{ $order->id }})" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                            Batal
                                        </button>
                                    </form>
                                </div>
                            @elseif($order->status === 'paid')
                                <span class="text-green-600 text-sm italic font-medium">Terverifikasi</span>
                            @else
                                <span class="text-red-400 text-sm italic">Dibatalkan</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-6 py-12 text-center text-gray-500 italic">
                            Belum ada pesanan masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-sm text-gray-500" id="orderInfo">Menampilkan <span id="orderShowingCount">0</span> dari <span id="orderTotalCount">{{ $orders->count() }}</span> pesanan</p>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1" id="orderPaginationControls"></div>
                <button onclick="printOrderReport()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Laporan
                </button>
            </div>
        </div>
    </div>

<!-- Modal Konfirmasi Verifikasi -->
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
    // ===== Modal Functions =====
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

    // ===== Search, Date, Status Filter & Pagination =====
    const ORDER_PER_PAGE = 10;
    let orderCurrentPage = 1;
    let orderFilteredRows = [];
    let currentStatusFilter = 'all';

    function setStatusFilter(status) {
        currentStatusFilter = status;
        // Update tab styles
        document.querySelectorAll('.status-tab').forEach(tab => {
            tab.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
            tab.classList.add('text-gray-500');
        });
        const activeTab = document.getElementById('tab-' + status);
        activeTab.classList.remove('text-gray-500');
        activeTab.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
        filterOrderTable();
    }

    function filterOrderTable() {
        const searchVal = document.getElementById('searchOrder').value.toLowerCase();
        const dateFrom = document.getElementById('orderDateFrom').value;
        const dateTo = document.getElementById('orderDateTo').value;
        const rows = document.querySelectorAll('.order-row');

        orderFilteredRows = [];

        rows.forEach(row => {
            const searchData = row.getAttribute('data-search');
            const rowDate = row.getAttribute('data-date');
            const rowStatus = row.getAttribute('data-status');

            let matchSearch = !searchVal || searchData.includes(searchVal);
            let matchDate = true;
            let matchStatus = currentStatusFilter === 'all' || rowStatus === currentStatusFilter;

            if (dateFrom && rowDate < dateFrom) matchDate = false;
            if (dateTo && rowDate > dateTo) matchDate = false;

            if (matchSearch && matchDate && matchStatus) {
                orderFilteredRows.push(row);
            }
        });

        orderCurrentPage = 1;
        renderOrderPage();
    }

    function renderOrderPage() {
        const rows = document.querySelectorAll('.order-row');
        const totalFiltered = orderFilteredRows.length;
        const totalPages = Math.max(1, Math.ceil(totalFiltered / ORDER_PER_PAGE));
        const start = (orderCurrentPage - 1) * ORDER_PER_PAGE;
        const end = start + ORDER_PER_PAGE;

        rows.forEach(row => row.style.display = 'none');

        orderFilteredRows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = '';
                row.querySelector('.order-row-number').textContent = index + 1;
            }
        });

        document.getElementById('orderShowingCount').textContent = totalFiltered === 0 ? '0' : `${start + 1}-${Math.min(end, totalFiltered)}`;
        document.getElementById('orderTotalCount').textContent = totalFiltered;

        const controls = document.getElementById('orderPaginationControls');
        controls.innerHTML = '';
        if (totalPages <= 1) return;

        const prevBtn = document.createElement('button');
        prevBtn.innerHTML = '&laquo;';
        prevBtn.className = `px-3 py-1.5 text-sm rounded-lg transition ${orderCurrentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'}`;
        prevBtn.disabled = orderCurrentPage === 1;
        prevBtn.onclick = () => { if (orderCurrentPage > 1) { orderCurrentPage--; renderOrderPage(); } };
        controls.appendChild(prevBtn);

        for (let i = 1; i <= totalPages; i++) {
            if (totalPages > 7 && i > 3 && i < totalPages - 2 && Math.abs(i - orderCurrentPage) > 1) {
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
            btn.className = `px-3 py-1.5 text-sm rounded-lg transition ${i === orderCurrentPage ? 'bg-blue-600 text-white font-bold' : 'text-gray-700 hover:bg-gray-100'}`;
            btn.onclick = () => { orderCurrentPage = i; renderOrderPage(); };
            controls.appendChild(btn);
        }

        const nextBtn = document.createElement('button');
        nextBtn.innerHTML = '&raquo;';
        nextBtn.className = `px-3 py-1.5 text-sm rounded-lg transition ${orderCurrentPage === totalPages ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'}`;
        nextBtn.disabled = orderCurrentPage === totalPages;
        nextBtn.onclick = () => { if (orderCurrentPage < totalPages) { orderCurrentPage++; renderOrderPage(); } };
        controls.appendChild(nextBtn);
    }

    function resetOrderDateFilter() {
        orderFpFrom.clear();
        orderFpTo.clear();
        filterOrderTable();
    }

    // ===== Print Report =====
    function printOrderReport() {
        const dateFrom = document.getElementById('orderDateFrom').value;
        const dateTo = document.getElementById('orderDateTo').value;
        let periodLabel = 'Semua Periode';
        if (dateFrom && dateTo) periodLabel = formatDateIDOrder(dateFrom) + ' - ' + formatDateIDOrder(dateTo);
        else if (dateFrom) periodLabel = 'Mulai ' + formatDateIDOrder(dateFrom);
        else if (dateTo) periodLabel = 'Sampai ' + formatDateIDOrder(dateTo);

        let statusLabel = 'Semua Status';
        if (currentStatusFilter === 'paid') statusLabel = 'Terverifikasi';
        else if (currentStatusFilter === 'canceled') statusLabel = 'Dibatalkan';
        else if (currentStatusFilter === 'pending') statusLabel = 'Pending';

        let totalOrders = 0;
        let totalRevenue = 0;
        let tableRows = '';

        orderFilteredRows.forEach((row, idx) => {
            const product = row.getAttribute('data-product-name');
            const customer = row.getAttribute('data-customer-name');
            const phone = row.getAttribute('data-customer-phone');
            const price = parseInt(row.getAttribute('data-price')) || 0;
            const qty = parseInt(row.getAttribute('data-quantity')) || 1;
            const total = parseInt(row.getAttribute('data-total')) || price;
            const date = row.getAttribute('data-order-date');
            const status = row.getAttribute('data-status');

            let statusText = 'PENDING';
            if (status === 'paid') statusText = 'LUNAS';
            else if (status === 'canceled') statusText = 'DIBATALKAN';

            totalOrders++;
            if (status === 'paid') totalRevenue += total;

            tableRows += '<tr>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px;text-align:center">' + (idx + 1) + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px">' + product + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px">' + customer + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px">' + phone + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px;text-align:right">Rp ' + price.toLocaleString('id-ID') + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px;text-align:center">' + qty + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px;text-align:right;font-weight:bold">Rp ' + total.toLocaleString('id-ID') + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px;text-align:center">' + date + '</td>';
            tableRows += '<td style="border:1px solid #ddd;padding:6px 10px;text-align:center;font-weight:bold">' + statusText + '</td>';
            tableRows += '</tr>';
        });

        const w = window.open('', '_blank');
        const d = w.document;
        d.open();
        d.write('<!DOCTYPE html><html><head><meta charset="utf-8">');
        d.write('<title>Laporan Pesanan - LF Catalog<' + '/title>');
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
        d.write('<p>Laporan Pesanan</p>');
        d.write('<p style="margin-top:6px;font-weight:bold">Periode: ' + periodLabel + ' | Status: ' + statusLabel + '</p>');
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
        d.write('<th style="text-align:center">Status</th>');
        d.write('</tr></thead>');
        d.write('<tbody>' + tableRows + '</tbody>');
        d.write('</table>');
        d.write('<div class="summary">');
        d.write('<div class="summary-grid">');
        d.write('<div class="summary-item"><div class="label">Total Pesanan</div><div class="value">' + totalOrders + '</div></div>');
        d.write('<div class="summary-item"><div class="label">Total Pendapatan (Lunas)</div><div class="value">Rp ' + totalRevenue.toLocaleString('id-ID') + '</div></div>');
        d.write('</div></div>');
        d.write('<div class="footer"><p>Dicetak pada: ' + new Date().toLocaleString('id-ID') + '</p><p>LF Catalog &copy; 2026</p></div>');
        d.write('<' + 'script>window.onload=function(){window.print()}<' + '/script>');
        d.write('<' + '/body><' + '/html>');
        d.close();
    }

    function formatDateIDOrder(dateStr) {
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
        const parts = dateStr.split('-');
        return parseInt(parts[2]) + ' ' + months[parseInt(parts[1]) - 1] + ' ' + parts[0];
    }

    // ===== Init Flatpickr & Table =====
    let orderFpFrom, orderFpTo;
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date();

        orderFpFrom = flatpickr('#orderDateFrom', {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'd M Y',
            defaultDate: today,
            disableMobile: true,
            onChange: function() { filterOrderTable(); }
        });

        orderFpTo = flatpickr('#orderDateTo', {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'd M Y',
            defaultDate: today,
            disableMobile: true,
            onChange: function() { filterOrderTable(); }
        });

        filterOrderTable();
    });
</script>
@endsection
