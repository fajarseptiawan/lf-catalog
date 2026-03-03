<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LF Catalog')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800">


    <main>
        @yield('content')
    </main>

     <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>

</body>
</html>
