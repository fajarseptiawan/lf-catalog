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
    <script>
        // Jika user masuk dari link langsung (bukan dari halaman lain di website),
        // sisipkan home ke history agar tombol Back tidak keluar dari website
        (function() {
            var homeUrl = "{{ url('/') }}";
            var isHomePage = window.location.pathname === '/' || window.location.pathname === '';
            var referrer = document.referrer;
            var isSameOrigin = referrer && referrer.startsWith(window.location.origin);

            if (!isHomePage && !isSameOrigin) {
                window.history.replaceState({ fromDirect: true }, '', window.location.href);
                window.history.pushState(null, '', window.location.href);
                window.addEventListener('popstate', function handleBack(e) {
                    window.removeEventListener('popstate', handleBack);
                    window.location.replace(homeUrl);
                }, { once: true });
            }
        })();
    </script>
    @stack('js')
</body>

</html>
