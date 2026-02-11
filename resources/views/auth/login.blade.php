@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="login-wrapper">

    {{-- LEFT --}}
    <div class="login-left">

        <div class="login-box">
            <h1 class="login-title">Selamat Datang Kembali!</h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label>Email</label>
                <input type="email"
                       name="email"
                       class="login-input"
                       placeholder="Masukkan email Anda"
                       required>

                <label>Password</label>
                <div class="password-wrapper">
                    <input type="password"
                           name="password"
                           id="loginPassword"
                           class="login-input"
                           placeholder="Masukkan password"
                           required>

                    <span class="toggle-password"
                          onclick="togglePassword('loginPassword', this)">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>

                <div class="login-options">
                    <label>
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>

                    <a href="{{ route('password.request') }}" class="forgot-link">
                        Lupa password?
                    </a>
                </div>

                <button class="btn-login">
                    Masuk
                </button>
            </form>

            {{-- Khusus Mobile --}}
            <div class="auth-switch">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar di sini</a>
            </div>
        </div>

    </div>

    {{-- Khusus Desktop --}}
    <div class="login-right">
        <div>
            <h2>Hallo!</h2>
            <p>
                Jika belum mempunyai akun,<br>
                Anda dapat daftar terlebih dahulu
            </p>

            <a href="{{ route('register') }}" class="btn-register">
                Daftar
            </a>
        </div>
    </div>

</div>
@endsection
