<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

   
    {{-- GLOBAL DATA UNTUK JS --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
   

    <title>@yield('title', 'MDA Partner')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

   @vite([
        'resources/css/public/public.css',
        'resources/js/app.js'
    ])

    
</head>
<body>

@include('partials.navbar-public')

<main>
    @yield('content')
</main>

@include('partials.footer')

@stack('scripts')
@include('partials.alert')

</body>
</html>
