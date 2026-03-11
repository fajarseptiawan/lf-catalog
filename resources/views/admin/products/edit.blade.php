@extends('layouts.admin')

@section('title', 'Edit Produk - Admin LF Catalog')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Edit Produk</h1>
    <p class="text-gray-500 mt-1">Memperbarui informasi untuk <strong>{{ $product->name }}</strong></p>
</div>

    <!-- Validation Errors -->
    @if($errors->any())
    <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 border border-red-100">
        <div class="flex items-center mb-2">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-semibold">Terdapat kesalahan pada input:</span>
        </div>
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Image Management Section (OUTSIDE main form to avoid nested forms) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Kelola Gambar</h2>

        {{-- Main Image --}}
        <div class="mb-8">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Utama</label>
            <div class="flex items-center gap-4">
                <img src="{{ asset($product->image) }}" alt="" class="h-20 w-20 object-contain bg-gray-50 rounded-lg p-1 border border-gray-100">
                <div class="flex flex-col gap-2">
                    <span class="text-xs text-gray-500 italic">Gambar utama saat ini</span>
                    @if($product->image && $product->image !== 'img/tes.png')
                    <form action="{{ route('admin.products.delete-image', $product->id) }}" method="POST" onsubmit="return confirm('Hapus gambar utama? Akan diganti dengan gambar default.')">
                        @csrf
                        <input type="hidden" name="image_path" value="{{ $product->image }}">
                        <input type="hidden" name="type" value="main">
                        <button type="submit" class="inline-flex items-center gap-1 text-xs text-red-600 hover:text-red-800 font-medium transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus Gambar Utama
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Slider Images --}}
        @if($product->images && count($product->images) > 0)
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Slider</label>
            <div class="flex gap-4 flex-wrap">
                @foreach($product->images as $idx => $img)
                <div class="relative group">
                    <img src="{{ asset($img) }}" alt="" class="h-20 w-20 object-contain bg-gray-50 rounded-lg p-1 border border-gray-100">
                    <form action="{{ route('admin.products.delete-image', $product->id) }}" method="POST" onsubmit="return confirm('Hapus gambar ini?')" class="absolute -top-2 -right-2">
                        @csrf
                        <input type="hidden" name="image_path" value="{{ $img }}">
                        <input type="hidden" name="type" value="slider">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-md transition" title="Hapus gambar">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Product Update Form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" maxlength="255" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('name') border-red-400 @enderror" required>
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('category') border-red-400 @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="iphone17" {{ old('category', $product->category) == 'iphone17' ? 'selected' : '' }}>iPhone 17 Series</option>
                        <option value="iphone16" {{ old('category', $product->category) == 'iphone16' ? 'selected' : '' }}>iPhone 16 Series</option>
                        <option value="iphone15" {{ old('category', $product->category) == 'iphone15' ? 'selected' : '' }}>iPhone 15 Series</option>
                        <option value="iphone14" {{ old('category', $product->category) == 'iphone14' ? 'selected' : '' }}>iPhone 14 Series</option>
                        <option value="iphone13" {{ old('category', $product->category) == 'iphone13' ? 'selected' : '' }}>iPhone 13 Series</option>
                        <option value="g2g" {{ old('category', $product->category) == 'g2g' ? 'selected' : '' }}>G2G</option>
                        <option value="softlens" {{ old('category', $product->category) == 'softlens' ? 'selected' : '' }}>Softlens</option>
                        <option value="aksesoris" {{ old('category', $product->category) == 'aksesoris' ? 'selected' : '' }}>Aksesoris HP (Universal)</option>
                    </select>
                    @error('category')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="1" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('price') border-red-400 @enderror" required>
                    @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Beli Supplier (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" min="0" step="1" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('purchase_price') border-red-400 @enderror" required>
                    @error('purchase_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" step="1" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('stock') border-red-400 @enderror" required>
                    @error('stock')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Produk <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('description') border-red-400 @enderror" required>{{ old('description', $product->description) }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ganti Gambar Utama</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" class="w-full px-4 py-3 rounded-xl border border-gray-200 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition">
                <p class="text-xs text-gray-500 mt-2">Upload gambar baru untuk mengganti gambar utama. Format: JPG, PNG, GIF, SVG. Maks. 2MB.</p>
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-10">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tambah Gambar Slider</label>
                <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" class="w-full px-4 py-3 rounded-xl border border-gray-200 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                <p class="text-xs text-gray-500 mt-2">Upload gambar baru untuk menambah slider. Format: JPG, PNG, GIF, SVG. Maks. 2MB per gambar.</p>
                @error('images.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-between items-center">
                 <a href="{{ route('admin.products') }}" class="text-gray-500 hover:text-gray-900 transition font-semibold">Batal</a>
                <button type="submit" class="bg-gray-900 hover:bg-black text-white px-10 py-4 rounded-full font-bold transition shadow-lg">
                    Update Produk
                </button>
            </div>
        </form>
    </div>
@endsection
