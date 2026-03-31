@extends('layouts.admin')

@section('title', 'Kelola Produk - LF Catalog')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Katalog Produk</h1>
        <p class="text-gray-500">Kelola informasi dan stok produk Anda</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-black transition shadow-sm font-semibold flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Produk
    </a>
</div>

    @if(session('success'))
        <div class="bg-green-50 text-green-600 p-4 rounded-xl mb-6 border border-green-100 flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Search Bar -->
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-500">Total: <span class="font-bold text-gray-900">{{ $products->count() }}</span> produk</p>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" id="searchProduct" class="pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white outline-none transition w-full sm:w-72" placeholder="Cari nama produk, kategori..." oninput="filterProductTable()">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="productTable">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Mitra</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga Beli</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga Jual</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="productTableBody">
                    @forelse($products as $index => $product)
                    <tr class="hover:bg-gray-50 transition product-row"
                        data-search="{{ strtolower($product->name . ' ' . $product->category . ' ' . ($product->mitra->store_name ?? '')) }}"
                        data-name="{{ $product->name }}"
                        data-category="{{ $product->category }}"
                        data-purchase-price="{{ $product->purchase_price }}"
                        data-sell-price="{{ $product->price }}"
                        data-stock="{{ $product->stock }}">
                        <td class="px-6 py-4 text-sm text-gray-500 prod-row-number">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-12 w-12 flex-shrink-0 bg-gray-50 rounded-lg p-1 mr-4 border border-gray-100">
                                    <img src="{{ asset($product->image) }}" alt="" class="h-full w-full object-contain">
                                </div>
                                <div class="font-semibold text-gray-900">{{ $product->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">{{ ucfirst($product->category) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->mitra)
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs font-medium">{{ $product->mitra->store_name }}</span>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-500">
                            Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold {{ $product->stock < 5 ? 'text-red-500' : 'text-gray-900' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="openRestockModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->purchase_price }})" class="text-green-600 hover:text-green-800 font-semibold text-sm">+ Stok</button>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold text-sm">Edit</a>
                                <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="button" onclick="openDeleteModal({{ $product->id }})" class="text-red-600 hover:text-red-900 font-semibold text-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-400 italic">
                            Belum ada produk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-sm text-gray-500" id="productInfo">Menampilkan <span id="prodShowingCount">0</span> dari <span id="prodTotalCount">{{ $products->count() }}</span> produk</p>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1" id="prodPaginationControls">
                </div>
                <button onclick="printStockReport()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Stok Opname
                </button>
            </div>
        </div>
    </div>

<!-- Restock Modal -->
<div id="restockModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeRestockModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all scale-95 opacity-0" id="restockModalContent">
        <button onclick="closeRestockModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <div class="mb-6">
            <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-green-100 mb-4">
                <svg class="h-7 w-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 text-center">Tambah Stok</h3>
            <p class="text-gray-500 text-center text-sm mt-1" id="restockProductName"></p>
        </div>
        <form id="restockForm" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Stok <span class="text-red-500">*</span></label>
                <input type="number" name="quantity" min="1" step="1" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition outline-none" placeholder="Contoh: 10" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Beli per Unit (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="purchase_price" id="restockPurchasePrice" min="0" step="1" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition outline-none" placeholder="Contoh: 5000000" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan</label>
                <input type="text" name="note" maxlength="500" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition outline-none" placeholder="Contoh: Restock dari supplier A">
            </div>
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition mt-2">
                Tambah Stok
            </button>
        </form>
    </div>
</div>

<!-- Stock History Table -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mt-8">
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Riwayat Penambahan Stok</h2>
            <p class="text-sm text-gray-500">Riwayat produk baru dan penambahan stok</p>
        </div>
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" id="searchHistory" class="pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:bg-white outline-none transition w-full sm:w-72" placeholder="Cari riwayat stok..." oninput="filterHistoryTable()">
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left" id="historyTable">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga Beli</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Total Biaya</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Catatan</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100" id="historyTableBody">
                @forelse($stockHistories as $index => $history)
                <tr class="hover:bg-gray-50 transition history-row"
                    data-search="{{ strtolower(($history->product->name ?? '') . ' ' . $history->type . ' ' . $history->note) }}">
                    <td class="px-6 py-4 text-sm text-gray-500 hist-row-number">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $history->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">
                        @if($history->type === 'new_product')
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Produk Baru</span>
                        @else
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Tambah Stok</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $history->product->name ?? '-' }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">+{{ $history->quantity }}</td>
                    <td class="px-6 py-4 text-gray-600">Rp {{ number_format($history->purchase_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($history->total_cost, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $history->note ?? '-' }}</td>
                    <td class="px-6 py-4 text-right">
                        <form id="delete-history-form-{{ $history->id }}" action="{{ route('admin.stock-history.delete', $history->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="button" onclick="openDeleteHistoryModal({{ $history->id }})" class="text-red-500 hover:text-red-700 font-semibold text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center text-gray-400 italic">
                        Belum ada riwayat penambahan stok.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="text-sm text-gray-500">Menampilkan <span id="histShowingCount">0</span> dari <span id="histTotalCount">{{ $stockHistories->count() }}</span> riwayat</p>
        <div class="flex items-center gap-1" id="histPaginationControls"></div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Riwayat Stok -->
<div id="deleteHistoryModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeDeleteHistoryModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all scale-95 opacity-0" id="deleteHistoryModalContent">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Riwayat Stok</h3>
            <p class="text-gray-600 mb-8">Apakah Anda yakin ingin menghapus riwayat ini? Total pengeluaran belanja akan berkurang sesuai nilai riwayat ini.</p>
            <div class="flex gap-3 justify-center">
                <button onclick="closeDeleteHistoryModal()" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition">
                    Batal
                </button>
                <button onclick="submitDeleteHistory()" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all scale-95 opacity-0" id="deleteModalContent">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-5">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Produk</h3>
            <p class="text-gray-600 mb-8">Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3 justify-center">
                <button onclick="closeDeleteModal()" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition">
                    Batal
                </button>
                <button onclick="submitDelete()" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // ===== Search & Pagination =====
    const PROD_PER_PAGE = 10;
    let prodCurrentPage = 1;
    let prodFilteredRows = [];

    function filterProductTable() {
        const searchVal = document.getElementById('searchProduct').value.toLowerCase();
        const rows = document.querySelectorAll('.product-row');

        prodFilteredRows = [];
        rows.forEach(row => {
            const searchData = row.getAttribute('data-search');
            if (!searchVal || searchData.includes(searchVal)) {
                prodFilteredRows.push(row);
            }
        });

        prodCurrentPage = 1;
        renderProductPage();
    }

    function renderProductPage() {
        const rows = document.querySelectorAll('.product-row');
        const totalFiltered = prodFilteredRows.length;
        const totalPages = Math.max(1, Math.ceil(totalFiltered / PROD_PER_PAGE));
        const start = (prodCurrentPage - 1) * PROD_PER_PAGE;
        const end = start + PROD_PER_PAGE;

        rows.forEach(row => row.style.display = 'none');

        prodFilteredRows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = '';
                row.querySelector('.prod-row-number').textContent = index + 1;
            }
        });

        document.getElementById('prodShowingCount').textContent = totalFiltered === 0 ? '0' : `${start + 1}-${Math.min(end, totalFiltered)}`;
        document.getElementById('prodTotalCount').textContent = totalFiltered;

        const controls = document.getElementById('prodPaginationControls');
        controls.innerHTML = '';
        if (totalPages <= 1) return;

        const prevBtn = document.createElement('button');
        prevBtn.innerHTML = '&laquo;';
        prevBtn.className = `px-3 py-1.5 text-sm rounded-lg transition ${prodCurrentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'}`;
        prevBtn.disabled = prodCurrentPage === 1;
        prevBtn.onclick = () => { if (prodCurrentPage > 1) { prodCurrentPage--; renderProductPage(); } };
        controls.appendChild(prevBtn);

        for (let i = 1; i <= totalPages; i++) {
            if (totalPages > 7 && i > 3 && i < totalPages - 2 && Math.abs(i - prodCurrentPage) > 1) {
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
            btn.className = `px-3 py-1.5 text-sm rounded-lg transition ${i === prodCurrentPage ? 'bg-blue-600 text-white font-bold' : 'text-gray-700 hover:bg-gray-100'}`;
            btn.onclick = () => { prodCurrentPage = i; renderProductPage(); };
            controls.appendChild(btn);
        }

        const nextBtn = document.createElement('button');
        nextBtn.innerHTML = '&raquo;';
        nextBtn.className = `px-3 py-1.5 text-sm rounded-lg transition ${prodCurrentPage === totalPages ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'}`;
        nextBtn.disabled = prodCurrentPage === totalPages;
        nextBtn.onclick = () => { if (prodCurrentPage < totalPages) { prodCurrentPage++; renderProductPage(); } };
        controls.appendChild(nextBtn);
    }

    // ===== Delete Modal =====
    let currentDeleteProductId = null;

    function openDeleteModal(productId) {
        currentDeleteProductId = productId;
        const modal = document.getElementById('deleteModal');
        const content = document.getElementById('deleteModalContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const content = document.getElementById('deleteModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 200);
        currentDeleteProductId = null;
    }

    function submitDelete() {
        if (currentDeleteProductId) {
            document.getElementById('delete-form-' + currentDeleteProductId).submit();
        }
    }

    // Init
    document.addEventListener('DOMContentLoaded', () => { filterProductTable(); filterHistoryTable(); });

    // ===== Restock Modal =====
    function openRestockModal(productId, productName, currentPurchasePrice) {
        document.getElementById('restockForm').action = '/admin/products/' + productId + '/restock';
        document.getElementById('restockProductName').textContent = productName;
        document.getElementById('restockPurchasePrice').value = currentPurchasePrice;

        const modal = document.getElementById('restockModal');
        const content = document.getElementById('restockModalContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeRestockModal() {
        const modal = document.getElementById('restockModal');
        const content = document.getElementById('restockModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 200);
    }

    // ===== Delete History Modal =====
    let currentDeleteHistoryId = null;

    function openDeleteHistoryModal(historyId) {
        currentDeleteHistoryId = historyId;
        const modal = document.getElementById('deleteHistoryModal');
        const content = document.getElementById('deleteHistoryModalContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeDeleteHistoryModal() {
        const modal = document.getElementById('deleteHistoryModal');
        const content = document.getElementById('deleteHistoryModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 200);
        currentDeleteHistoryId = null;
    }

    function submitDeleteHistory() {
        if (currentDeleteHistoryId) {
            document.getElementById('delete-history-form-' + currentDeleteHistoryId).submit();
        }
    }

    // ===== Stock History Search & Pagination =====
    const HIST_PER_PAGE = 10;
    let histCurrentPage = 1;
    let histFilteredRows = [];

    function filterHistoryTable() {
        const searchVal = document.getElementById('searchHistory').value.toLowerCase();
        const rows = document.querySelectorAll('.history-row');

        histFilteredRows = [];
        rows.forEach(row => {
            const searchData = row.getAttribute('data-search');
            if (!searchVal || searchData.includes(searchVal)) {
                histFilteredRows.push(row);
            }
        });

        histCurrentPage = 1;
        renderHistoryPage();
    }

    function renderHistoryPage() {
        const rows = document.querySelectorAll('.history-row');
        const totalFiltered = histFilteredRows.length;
        const totalPages = Math.max(1, Math.ceil(totalFiltered / HIST_PER_PAGE));
        const start = (histCurrentPage - 1) * HIST_PER_PAGE;
        const end = start + HIST_PER_PAGE;

        rows.forEach(row => row.style.display = 'none');

        histFilteredRows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = '';
                row.querySelector('.hist-row-number').textContent = index + 1;
            }
        });

        document.getElementById('histShowingCount').textContent = totalFiltered === 0 ? '0' : `${start + 1}-${Math.min(end, totalFiltered)}`;
        document.getElementById('histTotalCount').textContent = totalFiltered;

        const controls = document.getElementById('histPaginationControls');
        controls.innerHTML = '';
        if (totalPages <= 1) return;

        const prevBtn = document.createElement('button');
        prevBtn.innerHTML = '&laquo;';
        prevBtn.className = `px-3 py-1.5 text-sm rounded-lg transition ${histCurrentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'}`;
        prevBtn.disabled = histCurrentPage === 1;
        prevBtn.onclick = () => { if (histCurrentPage > 1) { histCurrentPage--; renderHistoryPage(); } };
        controls.appendChild(prevBtn);

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.className = `px-3 py-1.5 text-sm rounded-lg transition ${i === histCurrentPage ? 'bg-blue-600 text-white font-bold' : 'text-gray-700 hover:bg-gray-100'}`;
            btn.onclick = () => { histCurrentPage = i; renderHistoryPage(); };
            controls.appendChild(btn);
        }

        const nextBtn = document.createElement('button');
        nextBtn.innerHTML = '&raquo;';
        nextBtn.className = `px-3 py-1.5 text-sm rounded-lg transition ${histCurrentPage === totalPages ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-100'}`;
        nextBtn.disabled = histCurrentPage === totalPages;
        nextBtn.onclick = () => { if (histCurrentPage < totalPages) { histCurrentPage++; renderHistoryPage(); } };
        controls.appendChild(nextBtn);
    }

    // ===== Print Stock Opname Report =====
    function printStockReport() {
        const rows = document.querySelectorAll('.product-row');
        let tableRows = '';
        let totalSKU = 0;
        let totalStockValue = 0;
        let totalPurchaseValue = 0;
        let totalStock = 0;

        rows.forEach((row, idx) => {
            const name = row.getAttribute('data-name');
            const category = row.getAttribute('data-category');
            const purchasePrice = parseInt(row.getAttribute('data-purchase-price')) || 0;
            const sellPrice = parseInt(row.getAttribute('data-sell-price')) || 0;
            const stock = parseInt(row.getAttribute('data-stock')) || 0;

            totalSKU++;
            totalStock += stock;
            totalStockValue += sellPrice * stock;
            totalPurchaseValue += purchasePrice * stock;

            tableRows += '<tr>';
            tableRows += '<td style="border:1px solid #ccc;padding:6px 10px;text-align:center">' + (idx + 1) + '</td>';
            tableRows += '<td style="border:1px solid #ccc;padding:6px 10px">' + name + '</td>';
            tableRows += '<td style="border:1px solid #ccc;padding:6px 10px;text-align:center">' + category + '</td>';
            tableRows += '<td style="border:1px solid #ccc;padding:6px 10px;text-align:right">Rp ' + purchasePrice.toLocaleString('id-ID') + '</td>';
            tableRows += '<td style="border:1px solid #ccc;padding:6px 10px;text-align:right">Rp ' + sellPrice.toLocaleString('id-ID') + '</td>';
            tableRows += '<td style="border:1px solid #ccc;padding:6px 10px;text-align:center;font-weight:bold">' + stock + '</td>';
            tableRows += '<td style="border:1px solid #ccc;padding:6px 10px;min-width:80px"></td>';
            tableRows += '<td style="border:1px solid #ccc;padding:6px 10px;min-width:80px"></td>';
            tableRows += '</tr>';
        });

        const w = window.open('', '_blank');
        const d = w.document;
        d.open();
        d.write('<!DOCTYPE html><html><head><meta charset="utf-8">');
        d.write('<title>Laporan Stok Opname - LF Catalog<' + '/title>');
        d.write('<' + 'style>');
        d.write('@page{margin:12mm}');
        d.write('*{margin:0;padding:0;box-sizing:border-box}');
        d.write('body{font-family:Arial,sans-serif;font-size:11px;color:#333}');
        d.write('.header{text-align:center;margin-bottom:20px;border-bottom:2px solid #333;padding-bottom:15px}');
        d.write('.header h1{font-size:20px;margin-bottom:4px}');
        d.write('.header p{font-size:12px;color:#666}');
        d.write('table{width:100%;border-collapse:collapse;margin-top:10px}');
        d.write('th{background:#f0f0f0;border:1px solid #ccc;padding:8px 10px;text-align:left;font-size:10px;text-transform:uppercase}');
        d.write('td{font-size:10px}');
        d.write('.summary{margin-top:25px;border-top:2px solid #333;padding-top:15px}');
        d.write('.summary-grid{display:flex;justify-content:space-between;gap:15px}');
        d.write('.summary-item{text-align:center;flex:1;padding:10px;border:1px solid #ddd;border-radius:6px}');
        d.write('.summary-item .label{font-size:9px;text-transform:uppercase;color:#888;margin-bottom:3px}');
        d.write('.summary-item .value{font-size:16px;font-weight:bold}');
        d.write('.sign-area{margin-top:40px;display:flex;justify-content:space-between}');
        d.write('.sign-box{text-align:center;width:200px}');
        d.write('.sign-box .line{border-top:1px solid #333;margin-top:60px;padding-top:5px;font-size:10px}');
        d.write('.footer{text-align:center;margin-top:30px;font-size:9px;color:#aaa}');
        d.write('<' + '/style><' + '/head><body>');
        d.write('<div class="header">');
        d.write('<h1>LF CATALOG</h1>');
        d.write('<p>Laporan Stok Opname</p>');
        d.write('<p style="margin-top:6px;font-weight:bold">Tanggal: ' + new Date().toLocaleDateString('id-ID', {day:'numeric',month:'long',year:'numeric'}) + '</p>');
        d.write('</div>');
        d.write('<table>');
        d.write('<thead><tr>');
        d.write('<th style="text-align:center;width:35px">No</th>');
        d.write('<th>Produk</th>');
        d.write('<th style="text-align:center">Kategori</th>');
        d.write('<th style="text-align:right">Harga Beli</th>');
        d.write('<th style="text-align:right">Harga Jual</th>');
        d.write('<th style="text-align:center">Stok Sistem</th>');
        d.write('<th style="text-align:center">Stok Fisik</th>');
        d.write('<th style="text-align:center">Selisih</th>');
        d.write('</tr></thead>');
        d.write('<tbody>' + tableRows + '</tbody>');
        d.write('</table>');
        d.write('<div class="summary">');
        d.write('<div class="summary-grid">');
        d.write('<div class="summary-item"><div class="label">Total SKU</div><div class="value">' + totalSKU + '</div></div>');
        d.write('<div class="summary-item"><div class="label">Total Stok</div><div class="value">' + totalStock + '</div></div>');
        d.write('<div class="summary-item"><div class="label">Nilai Jual Stok</div><div class="value">Rp ' + totalStockValue.toLocaleString('id-ID') + '</div></div>');
        d.write('<div class="summary-item"><div class="label">Total Modal Stok</div><div class="value">Rp ' + totalPurchaseValue.toLocaleString('id-ID') + '</div></div>');
        d.write('</div></div>');
        d.write('<div class="sign-area">');
        d.write('<div class="sign-box"><div class="label" style="font-size:10px">Diperiksa oleh,</div><div class="line">( ........................ )</div></div>');
        d.write('<div class="sign-box"><div class="label" style="font-size:10px">Mengetahui,</div><div class="line">( ........................ )</div></div>');
        d.write('</div>');
        d.write('<div class="footer"><p>Dicetak pada: ' + new Date().toLocaleString('id-ID') + '</p><p>LF Catalog &copy; 2026</p></div>');
        d.write('<' + 'script>window.onload=function(){window.print()}<' + '/script>');
        d.write('<' + '/body><' + '/html>');
        d.close();
    }
</script>
@endsection
