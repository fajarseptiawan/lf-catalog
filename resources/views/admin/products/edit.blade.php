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
                        <option value="g2g" {{ old('category', $product->category) == 'g2g' ? 'selected' : '' }}>G2G Screen Protector</option>
                        <option value="softlens" {{ old('category', $product->category) == 'softlens' ? 'selected' : '' }}>Softlens</option>
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
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Utama (Biarkan kosong jika tidak ingin mengubah)</label>
                <div class="flex items-center mb-4">
                    <img src="{{ asset($product->image) }}" alt="" class="h-20 w-20 object-contain bg-gray-50 rounded-lg p-1 mr-4 border border-gray-100">
                    <span class="text-xs text-gray-500 italic">Gambar utama saat ini</span>
                </div>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" class="w-full px-4 py-3 rounded-xl border border-gray-200 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition">
                <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, GIF, SVG. Maks. 2MB.</p>
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-10">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Tambahan (Slider)</label>
                @if($product->images && count($product->images) > 0)
                <div class="flex gap-3 mb-4 flex-wrap">
                    @foreach($product->images as $img)
                    <img src="{{ asset($img) }}" alt="" class="h-16 w-16 object-contain bg-gray-50 rounded-lg p-1 border border-gray-100">
                    @endforeach
                </div>
                <p class="text-xs text-gray-500 mb-3 italic">Gambar slider saat ini. Upload baru akan menambahkan ke yang ada.</p>
                @endif
                <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" class="w-full px-4 py-3 rounded-xl border border-gray-200 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                <p class="text-xs text-gray-500 mt-2">Pilih beberapa gambar sekaligus. Format: JPG, PNG, GIF, SVG. Maks. 2MB per gambar.</p>
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
