<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Auth')</title>

    <!-- FONT (SAMA DENGAN APP) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- TAILWIND BASE (WAJIB) -->
    @vite(['resources/css/app.css'])

    <!-- CSS KHUSUS AUTH -->
    @vite(['resources/css/auth/login.css'])
</head>

<body class="font-sans antialiased auth-body">

    <main class="auth-main">
        @yield('content')
    </main>

    <footer class="auth-footer">
        © 2025 MDA Partner. All rights reserved.
    </footer>

</body>
</html>
