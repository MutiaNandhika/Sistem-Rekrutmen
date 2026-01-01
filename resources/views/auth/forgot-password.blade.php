@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
<div class="login-wrapper">

    {{-- LEFT --}}
    <div class="login-left">

        <h1 class="login-title">Lupa Password?</h1>

        <p style="margin-bottom:24px;font-size:14px;color:#6b7280;">
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
            <input type="email"
                   name="email"
                   class="login-input"
                   placeholder="Masukkan email Anda"
                   required>

            @error('email')
                <small style="color:red">{{ $message }}</small>
            @enderror

            <button class="btn-login">
                Kirim Link Reset
            </button>
        </form>

        <a href="{{ route('login') }}"
           style="margin-top:16px;display:inline-block;font-size:14px;">
            ← Kembali ke Login
        </a>

    </div>

    {{-- RIGHT --}}
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
