@extends('layouts.clear')

@section('title', 'Login - LF Catalog')

@section('content')
<section class="max-w-md mx-auto px-6 py-20">
    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Login</h1>
            <p class="text-gray-500">Masuk untuk mengelola katalog Anda</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition duration-200 outline-none" required value="{{ old('email') }}">
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-8">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition duration-200 outline-none" required>
            </div>

            <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white font-bold py-4 rounded-xl transition duration-300 shadow-lg">
                Sign In
            </button>
        </form>
    </div>
</section>
@endsection
