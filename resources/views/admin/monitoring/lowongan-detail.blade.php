@extends('layouts.admin')

@section('title', 'Detail Lowongan')

{{-- Breadcrumb --}}
@section('breadcrumb')
<nav class="breadcrumb-wrapper">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.monitoring.lowongan') }}">Monitoring Lowongan</a>
    <span>/</span>
    <span class="active">Detail Lowongan</span>
</nav>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Detail Lowongan</h4>
    <a href="{{ route('admin.monitoring.lowongan') }}"
       class="btn btn-light border">
        ← Kembali
    </a>
</div>

<div class="alert alert-info small">
    Admin hanya dapat melihat data lowongan untuk keperluan monitoring.
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">

        <h5 class="fw-bold mb-3">{{ $lowongan->nama_lowongan }}</h5>

        <div class="row small">
            <div class="col-md-6 mb-2">
                <strong>Bidang Kerja</strong><br>
                {{ $lowongan->bidangKerja->nama ?? '-' }}
            </div>

            <div class="col-md-6 mb-2">
                <strong>HRD / PIC</strong><br>
                {{ $lowongan->hrd->name ?? '-' }}
            </div>

            <div class="col-md-6 mb-2">
                <strong>Lokasi</strong><br>
                {{ $lowongan->lokasi }}
            </div>

            <div class="col-md-6 mb-2">
                <strong>Status</strong><br>
                {{ ucfirst($lowongan->status) }}
            </div>

            <div class="col-md-6 mb-2">
                <strong>Jumlah Dibutuhkan</strong><br>
                {{ $lowongan->jumlah_diterima }} orang
            </div>

            <div class="col-md-6 mb-2">
                <strong>Tanggal Dibuat</strong><br>
                {{ $lowongan->created_at->translatedFormat('d F Y') }}
            </div>
        </div>

        <hr>

        <h6 class="fw-bold">Deskripsi Pekerjaan</h6>
        <p class="text-muted">
            {!! nl2br(e($lowongan->deskripsi_pekerjaan)) !!}
        </p>

    </div>
</div>

@endsection
