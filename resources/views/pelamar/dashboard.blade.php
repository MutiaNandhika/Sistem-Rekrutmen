@extends('layouts.dashboard')

@section('title', 'Dashboard Pelamar')

@section('content')
<h4 class="mb-4">Selamat datang, {{ Auth::user()->name }}</h4>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Total Lamaran</h6>
                <h3>3</h3>
            </div>
        </div>
    </div>
</div>
@endsection
