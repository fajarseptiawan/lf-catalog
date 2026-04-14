@extends('layouts.admin')

@section('title', 'Tambah Produk - Admin LF Catalog')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Tambah Produk Baru</h1>
        <p class="text-gray-500">Silakan isi formulir di bawah untuk menambah produk baru ke katalog.</p>
    </div>
    <a href="{{ route('admin.products') }}" class="text-gray-500 hover:text-gray-900 flex items-center group transition font-medium">
        <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali
    </a>
</div>

    @if(session('error'))
        <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 border border-red-100 flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

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
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" maxlength="255" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('name') border-red-400 @enderror" placeholder="Contoh: iPhone 15 Pro Max" required>
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('category') border-red-400 @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        <optgroup label="Aksesoris iPhone">
                            <option value="iphone17" {{ old('category') == 'iphone17' ? 'selected' : '' }}>iPhone 17 Series</option>
                            <option value="iphone16" {{ old('category') == 'iphone16' ? 'selected' : '' }}>iPhone 16 Series</option>
                            <option value="iphone15" {{ old('category') == 'iphone15' ? 'selected' : '' }}>iPhone 15 Series</option>
                            <option value="iphone14" {{ old('category') == 'iphone14' ? 'selected' : '' }}>iPhone 14 Series</option>
                            <option value="iphone13" {{ old('category') == 'iphone13' ? 'selected' : '' }}>iPhone 13 Series</option>
                            <option value="charger" {{ old('category') == 'charger' ? 'selected' : '' }}>Charger iPhone</option>
                            <option value="aksesoris" {{ old('category') == 'aksesoris' ? 'selected' : '' }}>Aksesoris HP (Universal)</option>
                            <option value="softlens" {{ old('category') == 'softlens' ? 'selected' : '' }}>Softlens</option>
                        </optgroup>
                        <optgroup label="Sport Basket">
                            <option value="sepatubs" {{ old('category') == 'sepatubs' ? 'selected' : '' }}>Sepatu Basket</option>
                            <option value="kaoskakibs" {{ old('category') == 'kaoskakibs' ? 'selected' : '' }}>Kaos Kaki Basket</option>
                            <option value="bajubs" {{ old('category') == 'bajubs' ? 'selected' : '' }}>Baju Basket</option>
                            <option value="celanabs" {{ old('category') == 'celanabs' ? 'selected' : '' }}>Celana Basket</option>
                        </optgroup>
                        <optgroup label="Sport Futsal">
                            <option value="sepatufs" {{ old('category') == 'sepatufs' ? 'selected' : '' }}>Sepatu Futsal</option>
                            <option value="kaoskakifs" {{ old('category') == 'kaoskakifs' ? 'selected' : '' }}>Kaos Kaki Futsal</option>
                            <option value="bajufs" {{ old('category') == 'bajufs' ? 'selected' : '' }}>Baju Futsal</option>
                        </optgroup>
                        <optgroup label="Fashion Pria">
                            <option value="bajufp" {{ old('category') == 'bajufp' ? 'selected' : '' }}>Baju Pria</option>
                            <option value="sendalfp" {{ old('category') == 'sendalfp' ? 'selected' : '' }}>Sendal Pria</option>
                            <option value="jaketfp" {{ old('category') == 'jaketfp' ? 'selected' : '' }}>Jaket Pria</option>
                            <option value="topifp" {{ old('category') == 'topifp' ? 'selected' : '' }}>Topi Pria</option>
                            <option value="celanafp" {{ old('category') == 'celanafp' ? 'selected' : '' }}>Celana Pria</option>
                        </optgroup>
                        <optgroup label="Cosmetik G2G">
                            <option value="g2g" {{ old('category') == 'g2g' ? 'selected' : '' }}>G2G (Semua)</option>
                            <option value="facewashg2g" {{ old('category') == 'facewashg2g' ? 'selected' : '' }}>Facewash G2G</option>
                            <option value="moisturizerg2g" {{ old('category') == 'moisturizerg2g' ? 'selected' : '' }}>Moisturizer G2G</option>
                            <option value="serumg2g" {{ old('category') == 'serumg2g' ? 'selected' : '' }}>Serum G2G</option>
                            <option value="micelarwaterg2g" {{ old('category') == 'micelarwaterg2g' ? 'selected' : '' }}>Micelar Water G2G</option>
                            <option value="bodylotiong2g" {{ old('category') == 'bodylotiong2g' ? 'selected' : '' }}>Body Lotion G2G</option>
                        </optgroup>
                    </select>
                    @error('category')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    <label class="flex items-center gap-2 mt-3 cursor-pointer">
                        <input type="checkbox" name="is_temperedglass" value="1" {{ old('is_temperedglass') ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-200">
                        <span class="text-sm text-gray-600">Produk Antigores / Tempered Glass</span>
                    </label>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price') }}" min="0" step="1" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('price') border-red-400 @enderror" placeholder="Contoh: 15000000" required>
                    @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Beli Supplier (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="purchase_price" value="{{ old('purchase_price') }}" min="0" step="1" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('purchase_price') border-red-400 @enderror" placeholder="Contoh: 12000000" required>
                    @error('purchase_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stok Awal <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock') }}" min="0" step="1" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('stock') border-red-400 @enderror" placeholder="10" required>
                    @error('stock')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mitra Pemilik Produk</label>
                    <select name="mitra_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none">
                        <option value="">-- Tanpa Mitra (Milik Admin) --</option>
                        @foreach($mitras as $mitra)
                            <option value="{{ $mitra->id }}" {{ old('mitra_id') == $mitra->id ? 'selected' : '' }}>{{ $mitra->store_name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Opsional — pilih mitra jika produk ini milik mitra tertentu.</p>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Produk <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('description') border-red-400 @enderror" placeholder="Tulis deskripsi produk..." required>{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Utama Produk</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" class="w-full px-4 py-3 rounded-xl border border-gray-200 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition">
                <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, GIF, SVG. Maks. 2MB. Opsional — jika kosong akan menggunakan gambar default.</p>
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-10">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Tambahan (Slider)</label>
                <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" class="w-full px-4 py-3 rounded-xl border border-gray-200 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                <p class="text-xs text-gray-500 mt-2">Pilih beberapa gambar sekaligus. Format: JPG, PNG, GIF, SVG. Maks. 2MB per gambar.</p>
                @error('images.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-gray-900 hover:bg-black text-white px-10 py-4 rounded-full font-bold transition shadow-lg">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
@endsection
