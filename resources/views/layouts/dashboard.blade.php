<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard')</title>

    <link rel="icon" type="image/png" href="{{ asset('mda.png') }}">

    {{-- Vendor Styles --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Dashboard Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Page Styles --}}
    @stack('styles')
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    {{-- Dashboard Navbar --}}
    @include('partials.navbar-dashboard')

    {{-- Main Content --}}
    <main class="flex-fill container-fluid px-4 py-4">
        @yield('content')
    </main>

    {{-- Dashboard Footer --}}
    @include('partials.footer-dashboard')

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>
</html>
