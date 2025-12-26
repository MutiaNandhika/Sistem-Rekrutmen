@extends('layouts.admin')

@section('title', 'Detail Akun Admin')

@section('content')
<div class="container py-4">

    <h4 class="fw-bold mb-4">Detail Akun Admin</h4>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="mb-3">
                <label class="fw-semibold">Nama</label>
                <p class="mb-0">{{ $user->name }}</p>
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Email</label>
                <p class="mb-0">{{ $user->email }}</p>
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Role</label>
                <p class="mb-0">Admin</p>
            </div>

            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                Kembali
            </a>

        </div>
    </div>

</div>
@endsection
