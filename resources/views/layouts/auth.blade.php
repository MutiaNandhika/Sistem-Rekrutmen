<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    @vite([
        'resources/css/app.css',
        'resources/css/public.css',
        'resources/css/login.css'
    ])
</head>

<body class="auth-body">

    <main class="auth-main">
        @yield('content')
    </main>

    {{-- FOOTER KHUSUS AUTH --}}
    @include('partials.footer-auth')
    
</body>
</html>
