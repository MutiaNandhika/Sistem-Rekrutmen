@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="login-wrapper">

    {{-- LEFT --}}
    <div class="login-left">

        <h1 class="login-title">Buat Akun Baru</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- NAME --}}
            <label>Nama Lengkap</label>
            <input type="text"
                   name="name"
                   class="login-input"
                   placeholder="Masukkan nama lengkap"
                   value="{{ old('name') }}"
                   required>

            @error('name')
                <div class="login-alert">{{ $message }}</div>
            @enderror

            {{-- EMAIL --}}
            <label>Email</label>
            <input type="email"
                   name="email"
                   class="login-input"
                   placeholder="Masukkan email"
                   value="{{ old('email') }}"
                   required>

            @error('email')
                <div class="login-alert">{{ $message }}</div>
            @enderror

            {{-- PASSWORD --}}
            <label>Password</label>
            <input type="password"
                   name="password"
                   class="login-input"
                   placeholder="Masukkan password"
                   required>

            @error('password')
                <div class="login-alert">{{ $message }}</div>
            @enderror

            {{-- CONFIRM PASSWORD --}}
            <label>Konfirmasi Password</label>
            <input type="password"
                   name="password_confirmation"
                   class="login-input"
                   placeholder="Ulangi password"
                   required>

            <button class="btn-login">
                Daftar
            </button>
        </form>
    </div>

    {{-- RIGHT --}}
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
