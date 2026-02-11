<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard Admin')</title>

    <link rel="icon" type="image/png" href="{{ asset('mda.png') }}">

    {{-- CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

    {{-- JS (Head) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Dashboard Style --}}
    @vite(['resources/css/dashboard/dashboard.css'])

    @stack('styles')
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    {{-- Navbar --}}
    @include('partials.navbar-dashboard')

    {{-- Breadcrumb --}}
    @hasSection('breadcrumb')
        @yield('breadcrumb')
    @endif

    {{-- Main Content --}}
    <main class="container-fluid px-4 py-4 flex-fill">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer-dashboard')

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

    @include('partials.alert')
</body>
</html>
