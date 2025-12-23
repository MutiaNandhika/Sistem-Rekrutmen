@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="login-wrapper">

    {{-- LEFT --}}
    <div class="login-left">

        {{-- NOTIFIKASI DARI REDIRECT --}}
    @if(request('reason') === 'job_detail')
    <div class="login-alert">
        Silakan login terlebih dahulu untuk melihat detail lowongan.
    </div>
@endif

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
            <input type="password"
                   name="password"
                   class="login-input"
                   placeholder="Masukkan password Anda"
                   required>

            <div style="margin-bottom:20px;">
                <label>
                    <input type="checkbox" name="remember">
                    <span style="margin-left:6px;">Remember me</span>
                </label>
            </div>

            <button class="btn-login">
                Masuk
            </button>
        </form>
    </div>

    {{-- RIGHT --}}
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
