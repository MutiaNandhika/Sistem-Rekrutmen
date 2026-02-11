<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    {{-- App Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

    <div class="min-h-screen">

        @include('layouts.public')

        @yield('header')

        {{-- Main Content --}}
        <main class="py-8">
            @yield('content')
        </main>

    </div>

    {{-- Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('partials.alert')

</body>
</html>
