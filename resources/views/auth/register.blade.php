@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="login-wrapper">

    {{-- LEFT --}}
    <div class="login-left">

        <div class="login-box">
            <h1 class="login-title">Buat Akun Baru</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <label>Nama Lengkap</label>
                <input type="text"
                       name="name"
                       class="login-input"
                       placeholder="Masukkan nama lengkap"
                       value="{{ old('name') }}"
                       required>

                <label>Email</label>
                <input type="email"
                       name="email"
                       class="login-input"
                       placeholder="Masukkan email"
                       value="{{ old('email') }}"
                       required>

                <label>Password</label>
                <div class="password-wrapper">
                    <input type="password"
                           name="password"
                           id="registerPassword"
                           class="login-input"
                           placeholder="Masukkan password"
                           required>

                    <span class="toggle-password"
                          onclick="togglePassword('registerPassword', this)">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>

                <label>Konfirmasi Password</label>
                <div class="password-wrapper">
                    <input type="password"
                           name="password_confirmation"
                           id="registerPasswordConfirm"
                           class="login-input"
                           placeholder="Ulangi password"
                           required>

                    <span class="toggle-password"
                          onclick="togglePassword('registerPasswordConfirm', this)">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>

                <button class="btn-login">
                    Daftar
                </button>
            </form>

            {{-- Khusus Mobile --}}
            <div class="auth-switch">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </div>

    </div>

    {{-- Khusus Desktop --}}
    <div class="login-right">
        <div>
            <h2>Sudah Punya Akun?</h2>
            <p>
                Jika sudah mempunyai akun,<br>
                silakan login di sini
            </p>

            <a href="{{ route('login') }}" class="btn-register">
                Login
            </a>
        </div>
    </div>

</div>
@endsection
