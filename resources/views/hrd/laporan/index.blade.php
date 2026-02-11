@extends('layouts.hrd')

@section('title', 'Laporan Screening Kandidat')

@section('breadcrumb')
<nav class="breadcrumb-wrapper">
    <a href="{{ route('hrd.lowongan.index') }}">Lowongan</a>
    <span>/</span>
    <a href="{{ route('hrd.kandidat.index', $lowongan) }}">Kelola Kandidat</a>
    <span>/</span>
    <a href="{{ route('hrd.seleksi.index', $lowongan) }}">Seleksi (SAW)</a>
    <span>/</span>
    <span class="active">Lihat Laporan</span>
</nav>
@endsection


@section('content')

@if($apps->isEmpty())

    <div class="alert alert-warning">
        <strong>Belum ada hasil SAW.</strong><br>
        Silakan lakukan perhitungan SAW terlebih dahulu
        pada halaman <strong>Seleksi Kandidat</strong>.
    </div>

@else

<h4 class="fw-bold mb-3">
    Perhitungan Shortlisting Kandidat (Metode SAW)
</h4>

{{-- Action --}}
<div class="d-flex gap-2 mb-4">
    <a href="{{ route('hrd.laporan.pdf', $lowongan) }}"
       target="_blank"
       class="btn btn-danger">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </a>

    <a href="{{ route('hrd.laporan.excel', $lowongan) }}"
       class="btn btn-success">
        <i class="bi bi-file-earmark-excel"></i> Export Excel
    </a>
</div>

{{-- Informasi Lowongan --}}
<div class="card shadow-sm mb-4">
    <div class="card-body small">
        <strong>Informasi Lowongan</strong>
        <div class="mt-2">
            <div>[ Nama Lowongan ] : {{ $lowongan->nama_lowongan }}</div>
            <div>[ Jumlah Kandidat ] : {{ $apps->count() }} Orang</div>
            <div>[ Metode ] : Simple Additive Weighting (SAW)</div>
        </div>
    </div>
</div>

{{-- Kriteria dan Bobot --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <strong>Kriteria & Bobot</strong>

        <table class="table table-bordered table-sm text-center mt-3">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Kriteria</th>
                    <th>Jenis</th>
                    <th>Bobot</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>C1</td><td>Pendidikan</td><td>Benefit</td><td>0.30</td></tr>
                <tr><td>C2</td><td>Pengalaman</td><td>Benefit</td><td>0.40</td></tr>
                <tr><td>C3</td><td>Keahlian</td><td>Benefit</td><td>0.30</td></tr>
                <tr class="fw-bold"><td colspan="3">Total</td><td>1.00</td></tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Matriks Keputusan --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <strong>Data Awal Kandidat (Matriks Keputusan)</strong>

        <table class="table table-bordered table-sm text-center mt-3">
            <thead class="table-light">
                <tr>
                    <th>Kandidat</th>
                    <th>C1 (Pendidikan)</th>
                    <th>C2 (Pengalaman)</th>
                    <th>C3 (Keahlian)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($matrix as $m)
                <tr>
                    <td>{{ $m['nama'] }}</td>
                    <td>{{ $m['pendidikan'] }}</td>
                    <td>{{ $m['pengalaman'] }}</td>
                    <td>{{ $m['skill'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Matriks Normalisasi --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <strong>Matriks Normalisasi</strong>

        <table class="table table-bordered table-sm text-center mt-3">
            <thead class="table-light">
                <tr>
                    <th>Kandidat</th>
                    <th>R1</th>
                    <th>R2</th>
                    <th>R3</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($normalisasi as $appId => $r)
                <tr>
                    <td>{{ $matrix[$appId]['nama'] }}</td>
                    <td>{{ number_format($r['r1'], 3) }}</td>
                    <td>{{ number_format($r['r2'], 3) }}</td>
                    <td>{{ number_format($r['r3'], 3) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Hasil Ranking --}}
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <strong>Hasil Perankingan</strong>

        <table class="table table-bordered table-sm text-center mt-3">
            <thead class="table-light">
                <tr>
                    <th>Ranking</th>
                    <th>Kandidat</th>
                    <th>Skor SAW</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apps as $i => $app)
                <tr class="{{ $i === 0 ? 'fw-bold' : '' }}">
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $app->user->name }}</td>
                    <td>{{ number_format($app->saw_score, 3) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endif

@endsection
