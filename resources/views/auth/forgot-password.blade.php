@extends('layouts.auth')

@section('title', 'Lupa Password')

@push('auth-css')
@vite(['resources/css/auth/forgot-password.css'])
@endpush

@section('content')
<div class="login-wrapper forgot-password-page">

    <div class="login-left">
        <h1 class="login-title">Lupa Password?</h1>

        <p class="login-desc">
            Masukkan email Anda. Kami akan mengirimkan link untuk reset password.
        </p>

        @if (session('status'))
            <div class="login-alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <label>Email</label>
            <input
                type="email"
                name="email"
                class="login-input"
                placeholder="Masukkan email Anda"
                required
            >

            @error('email')
                <small class="text-error">{{ $message }}</small>
            @enderror

            <button type="submit" class="btn-login">
                Kirim Link Reset
            </button>
        </form>

        <a href="{{ route('login') }}" class="back-login">
            ← Kembali ke Login
        </a>
    </div>

    <div class="login-right">
        <div>
            <h2>Butuh Bantuan?</h2>
            <p>
                Pastikan email yang Anda masukkan<br>
                terdaftar di sistem
            </p>
        </div>
    </div>

</div>
@endsection
