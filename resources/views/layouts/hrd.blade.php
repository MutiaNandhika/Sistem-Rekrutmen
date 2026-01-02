<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard HRD')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Dashboard CSS --}}
    @vite(['resources/css/dashboard/dashboard.css'])

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">

    {{-- NAVBAR DASHBOARD --}}
    @include('partials.navbar-dashboard')
    
{{-- BREADCRUMB (OPTIONAL) --}}
@hasSection('breadcrumb')
    @yield('breadcrumb')
@endif

    <main class="container-fluid px-4 py-4 flex-fill">
        @yield('content')
    </main>

    {{-- FOOTER DASHBOARD --}}
    @include('partials.footer-dashboard')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('scripts')
</body>
</html>
