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
        <div class="jobs-filter mb-5">
            <div class="row g-3">

                {{-- ROW 1 --}}
                <div class="col-md-6">
                    <input type="text"
                           class="form-control jobs-input"
                           placeholder="Posisi">
                </div>

                <div class="col-md-6">
                    <select class="form-select jobs-input">
                        <option value="">Lokasi</option>
                        <option>Jakarta</option>
                        <option>Bandung</option>
                        <option>Surabaya</option>
                    </select>
                </div>

                {{-- ROW 2 --}}
                <div class="col-md-3">
                    <input type="text"
                           class="form-control jobs-input"
                           placeholder="Perusahaan">
                </div>

                <div class="col-md-3">
                    <select class="form-select jobs-input">
                        <option value="">Tipe Pekerjaan</option>
                        <option>Full Time</option>
                        <option>Part Time</option>
                        <option>Kontrak</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select class="form-select jobs-input">
                        <option value="">Kebijakan Kerja</option>
                        <option>WFO</option>
                        <option>WFH</option>
                        <option>Hybrid</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-jobs-search w-100">
                        <i class="bi bi-search me-2"></i> Search
                    </button>
                </div>

            </div>
        </div>

        {{-- JOB LIST --}}
        <div class="row g-4">
            @for ($i = 0; $i < 6; $i++)
                <div class="col-md-6 col-lg-4">
                    <div class="job-card">

                        <h5 class="job-title">Office Girl</h5>

                        <div class="job-tags">
                            <span class="badge">Kontrak</span>
                            <span class="badge">Kerja di Kantor</span>
                        </div>

                        <div class="job-meta">
                            <div><i class="bi bi-building"></i> PT JNE</div>
                            <div><i class="bi bi-geo-alt"></i> Bandung</div>
                        </div>

                        <a href="{{ route('jobs.show', 1) }}" class="btn btn-job-detail">
                            <i class="bi bi-arrow-right-circle"></i>
                            Detail
                        </a>
                    </div>
                </div>
            @endfor
        </div>

    </div>
</section>
@endsection
