<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Auth')</title>

    {{-- CSS KHUSUS AUTH --}}
    @vite(['resources/css/auth/login.css'])
</head>

<body class="auth-body">

    <main class="auth-main">
        @yield('content')
    </main>

    {{-- FOOTER KHUSUS AUTH --}}
    <footer class="auth-footer">
        © 2025 MDA Partner. All rights reserved.
    </footer>

</body>
</html>
