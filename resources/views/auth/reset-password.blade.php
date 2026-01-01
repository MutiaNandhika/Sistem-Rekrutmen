@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="login-wrapper">

    <div class="login-left">

        <h1 class="login-title">Reset Password</h1>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <label>Email</label>
            <input type="email"
                   name="email"
                   class="login-input"
                   value="{{ old('email', $request->email) }}"
                   required>

            <label>Password Baru</label>
            <input type="password"
                   name="password"
                   class="login-input"
                   required>

            <label>Konfirmasi Password</label>
            <input type="password"
                   name="password_confirmation"
                   class="login-input"
                   required>

            <button class="btn-login">
                Reset Password
            </button>
        </form>

    </div>

    <div class="login-right">
        <div>
            <h2>Keamanan Akun</h2>
            <p>
                Gunakan password yang kuat<br>
                dan mudah diingat
            </p>
        </div>
    </div>

</div>
@endsection
