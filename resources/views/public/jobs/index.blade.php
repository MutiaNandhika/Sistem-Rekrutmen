@extends('layouts.public')

@section('title', 'Lowongan Pekerjaan')

@section('content')
<section class="jobs-section py-5">
    <div class="container">

        {{-- TITLE --}}
        <div class="text-center mb-4">
            <h2 class="jobs-title">Daftar Lowongan</h2>
            <p class="jobs-subtitle">
                Temukan lowongan pekerjaan yang sesuai dengan minat dan keahlian Anda.
            </p>
        </div>

        {{-- FILTER --}}
        <form method="GET" class="jobs-filter mb-5" action="{{ route('jobs.index') }}">
            <div class="row g-3">

                <div class="col-md-6">
                    <input type="text"
                           name="posisi"
                           class="form-control jobs-input"
                           placeholder="Posisi"
                           value="{{ request('posisi') }}">
                </div>

                <div class="col-md-6">
                    <input type="text"
                           name="lokasi"
                           class="form-control jobs-input"
                           placeholder="Lokasi"
                           value="{{ request('lokasi') }}">
                </div>

                <div class="col-md-3">
                    <input type="text"
                           name="penempatan"
                           class="form-control jobs-input"
                           placeholder="Penempatan"
                           value="{{ request('penempatan') }}">
                </div>

                <div class="col-md-3">
                    <select name="tipe_kerja" class="form-select jobs-input">
                        <option value="">Tipe Pekerjaan</option>
                        <option value="kontrak" @selected(request('tipe_kerja')=='kontrak')>Kontrak</option>
                        <option value="penuh_waktu" @selected(request('tipe_kerja')=='penuh_waktu')>Penuh Waktu</option>
                        <option value="paruh_waktu" @selected(request('tipe_kerja')=='paruh_waktu')>Paruh Waktu</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="sistem_kerja" class="form-select jobs-input">
                        <option value="">Kebijakan Kerja</option>
                        <option value="kantor" @selected(request('sistem_kerja')=='kantor')>Kantor</option>
                        <option value="remote" @selected(request('sistem_kerja')=='remote')>Remote</option>
                        <option value="hybrid" @selected(request('sistem_kerja')=='hybrid')>Hybrid</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-jobs-search w-100">
                    <i class="bi bi-search me-2"></i> Search
                </button>

                <a href="{{ route('jobs.index') }}"
                class="btn btn-outline-secondary w-100">
                    Reset
                </a>
            </div>

            </div>
        </form>

        @if(request()->query()) <div class="alert alert-info small"> Menampilkan hasil pencarian <a href="{{ route('jobs.index') }}" class="ms-2">Reset filter</a> </div> @endif

        {{-- JOB LIST --}}
        <div class="row g-4">

            @forelse ($lowongans as $lowongan)
                <div class="col-md-6 col-lg-4">
                    <div class="job-card">

                        <h5 class="job-title">{{ $lowongan->nama_lowongan }}</h5>

                        <div class="job-tags">
                            <span class="badge">
                                {{ ucfirst(str_replace('_',' ',$lowongan->tipe_kerja)) }}
                            </span>
                            <span class="badge">
                                {{ ucfirst($lowongan->sistem_kerja) }}
                            </span>
                        </div>

                        <div class="job-meta">
                            <div><i class="bi bi-building"></i> {{ $lowongan->penempatan ?? 'Perusahaan Mitra' }}</div>
                            <div><i class="bi bi-geo-alt"></i> {{ $lowongan->lokasi }}</div>
                        </div>

                        {{-- BATAS PENDAFTARAN --}}
                        @if ($lowongan->tanggal_selesai)
                            <div class="job-deadline text-muted small mt-2">
                                <i class="bi bi-calendar-x"></i>
                                Ditutup:
                                <strong>
                                    {{ \Carbon\Carbon::parse($lowongan->tanggal_selesai)->translatedFormat('d M Y') }}
                                </strong>
                            </div>
                        @else
                            <div class="job-deadline text-muted small mt-2">
                                <i class="bi bi-calendar-check"></i>
                                Tanpa batas pendaftaran
                            </div>
                        @endif

                        <a href="{{ route('jobs.show', $lowongan->id) }}"
                           class="btn btn-job-detail">
                            <i class="bi bi-arrow-right-circle"></i>
                            Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    Tidak ada lowongan sesuai pencarian.
                </div>
            @endforelse

        </div>

    </div>
</section>
@endsection
