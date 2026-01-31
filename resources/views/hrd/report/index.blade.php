@extends('layouts.hrd')

@section('title','Laporan Rekrutmen')

@section('content')

<h4 class="fw-bold mb-1">Laporan Rekrutmen (HRD)</h4>
<p class="text-muted mb-4">
    Halaman ini menampilkan ringkasan proses rekrutmen berdasarkan periode dan lowongan yang Anda kelola.
    Data dapat diunduh dalam bentuk PDF atau Excel untuk keperluan evaluasi dan pelaporan.
</p>

{{-- ================= FILTER ================= --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">

            <div class="col-md-3">
                <label class="form-label small text-muted">Tanggal Mulai</label>
                <input type="date" name="from" value="{{ $from }}" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label small text-muted">Tanggal Akhir</label>
                <input type="date" name="to" value="{{ $to }}" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label small text-muted">Lowongan</label>
                <select name="lowongan_id" class="form-select">
                    <option value="">Semua Lowongan</option>
                    @foreach ($lowongans as $l)
                        <option value="{{ $l->id }}"
                            {{ request('lowongan_id') == $l->id ? 'selected' : '' }}>
                            {{ $l->nama_lowongan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">
                    Tampilkan
                </button>
            </div>

        </form>
    </div>
</div>

{{-- ================= STATISTIK ================= --}}
<div class="row g-3 mb-4">

    @php
        $stats = [
            ['Total Pelamar', $totalPelamar],
            ['Screening', $screening],
            ['Seleksi (SAW)', $seleksiSaw],
            ['Interview', $interview],
            ['Offer', $offer],
            ['Selesai - Diterima', $diterima],
            ['Selesai - Ditolak', $ditolak],
        ];
    @endphp

    @foreach ($stats as [$label, $value])
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-muted small">{{ $label }}</div>
                    <h5 class="fw-bold">{{ $value }}</h5>
                </div>
            </div>
        </div>
    @endforeach

    <div class="col-md-3">
        <div class="card text-center border-success">
            <div class="card-body">
                <div class="text-muted small">Persentase Lolos</div>
                <h5 class="fw-bold text-success">
                    {{ $persenLolos }}%
                </h5>
            </div>
        </div>
    </div>

</div>


{{-- ================= EXPORT ================= --}}
<div class="d-flex gap-2">
    <a href="{{ route('hrd.report.pdf', request()->query()) }}"
       target="_blank"
       class="btn btn-danger">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </a>

    <a href="{{ route('hrd.report.excel', request()->query()) }}"
       class="btn btn-success">
        <i class="bi bi-file-earmark-excel"></i> Export Excel
    </a>
</div>

@endsection
