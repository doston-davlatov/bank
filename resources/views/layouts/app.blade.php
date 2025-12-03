<!DOCTYPE html>
<html lang="uz" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyBank') - Raqamli Bank</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 font-sans">
@include('partials.navbar')

<main class="container mx-auto px-4 py-8 max-w-7xl">
    @yield('content')
</main>

<footer class="bg-gray-800 text-white py-8 mt-16">
    <div class="container mx-auto text-center">
        © {{ date('Y') }} MyBank. Barcha huquqlar himoyalangan.
    </div>
</footer>
</body>
</html>
