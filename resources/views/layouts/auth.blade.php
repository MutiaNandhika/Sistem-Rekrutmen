<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Auth')</title>

    <link rel="icon" type="image/png" href="{{ asset('mda.png') }}">

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- App Base --}}
    @vite(['resources/css/app.css'])

    {{-- Auth Styles --}}
    @vite(['resources/css/auth/login.css'])

    {{-- Auth CSS --}}
    @stack('auth-css')
</head>

<body class="font-sans antialiased auth-body">

    {{-- Auth Content --}}
    <main class="auth-main">
        @yield('content')
    </main>

    {{-- Auth Footer --}}
    <footer class="auth-footer">
        © 2025 MDA Partner. All rights reserved.
    </footer>

    {{-- Scripts --}}
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
