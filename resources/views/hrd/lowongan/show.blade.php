@extends('layouts.hrd')

@section('title', 'Detail Lowongan')

@section('breadcrumb')
<nav class="breadcrumb-wrapper">
    <a href="{{ route('hrd.dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('lowongan.index') }}">Lowongan</a>
    <span>/</span>
    <span class="active">Detail Lowongan</span>
</nav>
@endsection

@section('content')

<h4 class="fw-bold text-center mb-4">Detail Lowongan Kerja</h4>

{{-- ================= INFO UTAMA ================= --}}
<div class="card mb-4">
    <div class="card-header fw-semibold">
        Informasi Lowongan
    </div>
    <div class="card-body">

        <div class="row mb-3">
            <div class="col-md-4 text-muted">Nama Lowongan</div>
            <div class="col-md-8 fw-semibold">{{ $lowongan->nama_lowongan }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 text-muted">Bidang Kerja</div>
            <div class="col-md-8">{{ $lowongan->bidang_kerja }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 text-muted">Tipe Kerja</div>
            <div class="col-md-8">
                {{ ucfirst(str_replace('_',' ',$lowongan->tipe_kerja)) }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 text-muted">Sistem Kerja</div>
            <div class="col-md-8">
                {{ ucfirst($lowongan->sistem_kerja) }}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 text-muted">Lokasi</div>
            <div class="col-md-8">{{ $lowongan->lokasi }}</div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 text-muted">Status</div>
            <div class="col-md-8">
                <span class="status-badge {{ $lowongan->status }}">
                    {{ ucfirst($lowongan->status) }}
                </span>
            </div>
        </div>

    </div>
</div>

{{-- ================= GAJI ================= --}}
<div class="card mb-4">
    <div class="card-header fw-semibold">
        Informasi Gaji
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <strong>Minimal:</strong>
                Rp {{ number_format($lowongan->gaji_min ?? 0,0,',','.') }}
            </div>
            <div class="col-md-6">
                <strong>Maksimal:</strong>
                Rp {{ number_format($lowongan->gaji_max ?? 0,0,',','.') }}
            </div>
        </div>
    </div>
</div>

{{-- ================= PERSYARATAN ================= --}}
<div class="card mb-4">
    <div class="card-header fw-semibold">
        Persyaratan Kerja
    </div>
    <div class="card-body">

        <div class="row mb-2">
            <div class="col-md-4 text-muted">Jenis Kelamin</div>
            <div class="col-md-8">{{ ucfirst($lowongan->jenis_kelamin ?? '-') }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 text-muted">Usia</div>
            <div class="col-md-8">
                @if ($lowongan->tanpa_batas_usia)
                    Tidak ada batas usia
                @else
                    {{ $lowongan->usia_min }} – {{ $lowongan->usia_max }} tahun
                @endif
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 text-muted">Pendidikan Minimal</div>
            <div class="col-md-8">{{ $lowongan->pendidikan_minimal ?? '-' }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 text-muted">Pengalaman Kerja</div>
            <div class="col-md-8">
                {{ ucfirst(str_replace('_',' ',$lowongan->pengalaman_kerja ?? '-')) }}
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 text-muted">Skill</div>
            <div class="col-md-8">
                @if ($lowongan->skills->count())
                    <ul class="mb-0">
                        @foreach ($lowongan->skills as $skill)
                            <li>{{ $skill->nama_skill }}</li>
                        @endforeach
                    </ul>
                @else
                    -
                @endif
            </div>
        </div>

    </div>
</div>

{{-- ================= DESKRIPSI ================= --}}
<div class="card mb-5">
    <div class="card-header fw-semibold">
        Deskripsi Pekerjaan
    </div>
    <div class="card-body">
        {!! nl2br(e($lowongan->deskripsi_pekerjaan ?? '-')) !!}
    </div>
</div>

{{-- ACTION --}}
<div class="text-end">
    <a href="{{ route('lowongan.index') }}" class="btn btn-light border">
        Kembali
    </a>
</div>

@endsection
