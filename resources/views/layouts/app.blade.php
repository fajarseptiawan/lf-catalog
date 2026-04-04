<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo_lfc.png') }}">
    <title>@yield('title', 'LF Catalog')</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @stack('css')
</head>

<body class="bg-white text-gray-800">

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    @stack('js')
</body>

</html>
