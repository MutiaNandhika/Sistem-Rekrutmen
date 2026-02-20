<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'MDA Partner')</title>

    <link rel="icon" type="image/png" href="{{ asset('mda.png') }}">

    {{-- Styles --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Public Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/js/profile/index.js'])

</head>

<body>

    {{-- Navbar --}}
    @include('partials.navbar-public')

    {{-- Breadcrumb --}}
    @hasSection('breadcrumb')
        @yield('breadcrumb')
    @endif

    {{-- Main Content --}}
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Alert --}}
    @include('partials.alert')

</body>
</html>
