@extends('layouts.admin')

@section('title', 'Kelola Mitra - Admin LF Catalog')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kelola Mitra</h1>
        <p class="text-gray-500">Kelola daftar mitra yang terdaftar di sistem</p>
    </div>
    <div class="flex items-center gap-3">
        <form action="{{ route('admin.mitras.sync-telegram') }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600 transition shadow-sm font-semibold flex items-center text-sm">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                Sync Telegram
            </button>
        </form>
        <button onclick="document.getElementById('addMitraModal').classList.remove('hidden'); document.getElementById('addMitraModal').classList.add('flex');" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-black transition shadow-sm font-semibold flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Mitra
        </button>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-50 text-green-600 p-4 rounded-xl mb-6 border border-green-100 flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        {{ session('success') }}
    </div>
@endif

@if(session('info'))
    <div class="bg-blue-50 text-blue-600 p-4 rounded-xl mb-6 border border-blue-100 flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('info') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 border border-red-100 flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
<div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 border border-red-100">
    <ul class="list-disc list-inside text-sm space-y-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <p class="text-sm text-gray-500">Total: <span class="font-bold text-gray-900">{{ $mitras->count() }}</span> mitra</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Mitra</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Toko</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">WhatsApp</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Telegram ID</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($mitras as $index => $mitra)
                <tr class="hover:bg-gray-50 transition {{ !$mitra->is_active ? 'opacity-50' : '' }}">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900">{{ $mitra->user->name ?? '-' }}</div>
                        @if($mitra->address)
                        <div class="text-xs text-gray-400 mt-0.5 line-clamp-1 max-w-xs">{{ $mitra->address }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-700">{{ $mitra->store_name ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $mitra->user->email ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $mitra->phone ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @if($mitra->telegram_chat_id)
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 bg-green-50 text-green-700 rounded-full text-xs font-semibold border border-green-200">✓ Terhubung</span>
                                <span class="font-mono text-xs text-gray-400">{{ $mitra->telegram_chat_id }}</span>
                            </div>
                        @elseif($mitra->telegram_link_code)
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs font-semibold border border-yellow-200">Menunggu</span>
                                <code class="bg-gray-100 px-2 py-0.5 rounded text-xs font-mono font-bold text-gray-800">{{ $mitra->telegram_link_code }}</code>
                            </div>
                        @else
                            <form action="{{ route('admin.mitras.regenerate-link', $mitra->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Generate Kode</button>
                            </form>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold">
                            {{ $mitra->products()->count() }} produk
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.mitras.toggle', $mitra->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-1 rounded-full text-xs font-semibold border transition {{ $mitra->is_active ? 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100' : 'bg-red-50 text-red-700 border-red-200 hover:bg-red-100' }}" title="{{ $mitra->is_active ? 'Klik untuk nonaktifkan' : 'Klik untuk aktifkan' }}">
                                {{ $mitra->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <button onclick="openEditMitraModal({{ $mitra->id }}, '{{ addslashes($mitra->store_name) }}', '{{ addslashes($mitra->user->name ?? '') }}', '{{ $mitra->user->email ?? '' }}', '{{ $mitra->phone ?? '' }}', '{{ addslashes($mitra->address ?? '') }}', '{{ $mitra->telegram_chat_id ?? '' }}')"
                                class="text-blue-600 hover:text-blue-800 font-medium text-xs transition inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit
                            </button>
                            <form action="{{ route('admin.mitras.delete', $mitra->id) }}" method="POST" onsubmit="return confirm('Hapus mitra {{ addslashes($mitra->store_name) }}? Produk terkait akan dilepas dari mitra ini.')" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-xs transition inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center text-gray-400 italic">
                        Belum ada mitra terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Mitra Modal --}}
<div id="addMitraModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" onclick="if(event.target===this){this.classList.add('hidden');this.classList.remove('flex')}">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8 relative max-h-[90vh] overflow-y-auto">
        <button onclick="this.closest('#addMitraModal').classList.add('hidden');this.closest('#addMitraModal').classList.remove('flex')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Tambah Mitra Baru
        </h3>
        <form action="{{ route('admin.mitras.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                {{-- Info Toko --}}
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Info Toko / Brand</p>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Toko / Brand</label>
                        <input type="text" name="store_name" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none" placeholder="Contoh: Toko ABC" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp</label>
                            <input type="text" name="phone" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none" placeholder="08xxxx">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Telegram Chat ID</label>
                            <input type="text" name="telegram_chat_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none" placeholder="123456789">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                        <textarea name="address" rows="2" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none" placeholder="Alamat mitra (opsional)"></textarea>
                    </div>
                </div>

                {{-- Akun Login --}}
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Akun Login Mitra</p>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Mitra <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none" placeholder="Nama lengkap mitra" required>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Login <span class="text-red-500">*</span></label>
                        <input type="email" name="email" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none" placeholder="email@contoh.com" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white py-3 rounded-xl font-bold transition shadow-lg mt-2">
                    Tambah Mitra
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Mitra Modal --}}
<div id="editMitraModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" onclick="if(event.target===this){this.classList.add('hidden');this.classList.remove('flex')}">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8 relative max-h-[90vh] overflow-y-auto">
        <button onclick="this.closest('#editMitraModal').classList.add('hidden');this.closest('#editMitraModal').classList.remove('flex')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Edit Mitra
        </h3>
        <form id="editMitraForm" method="POST">
            @csrf
            <div class="space-y-4">
                {{-- Info Toko --}}
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Info Toko / Brand</p>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Toko / Brand</label>
                        <input type="text" name="store_name" id="editMitraStoreName" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp</label>
                            <input type="text" name="phone" id="editMitraPhone" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Telegram Chat ID</label>
                            <input type="text" name="telegram_chat_id" id="editMitraTelegram" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                        <textarea name="address" id="editMitraAddress" rows="2" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none" placeholder="Alamat mitra (opsional)"></textarea>
                    </div>
                </div>

                {{-- Akun Login --}}
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Akun Login Mitra</p>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Mitra <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="editMitraName" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none" required>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Login <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="editMitraEmail" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru <span class="text-xs text-gray-400 font-normal">(kosongkan jika tidak diubah)</span></label>
                            <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none">
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white py-3 rounded-xl font-bold transition shadow-lg mt-2">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditMitraModal(id, storeName, name, email, phone, address, telegram) {
    document.getElementById('editMitraForm').action = '/admin/mitras/update/' + id;
    document.getElementById('editMitraStoreName').value = storeName;
    document.getElementById('editMitraName').value = name;
    document.getElementById('editMitraEmail').value = email;
    document.getElementById('editMitraPhone').value = phone;
    document.getElementById('editMitraAddress').value = address;
    document.getElementById('editMitraTelegram').value = telegram;
    document.getElementById('editMitraModal').classList.remove('hidden');
    document.getElementById('editMitraModal').classList.add('flex');
}
</script>
@endsection
