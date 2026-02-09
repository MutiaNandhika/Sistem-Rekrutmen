<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Auth')</title>

    <link rel="icon" type="image/png" href="{{ asset('mda.png') }}">

    <!-- FONT (SAMA DENGAN APP) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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

<script>
function togglePassword(inputId, el) {
    const input = document.getElementById(inputId);
    const icon = el.querySelector('i');

    if (!input) return;

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('partials.alert')
</body>
</html>
