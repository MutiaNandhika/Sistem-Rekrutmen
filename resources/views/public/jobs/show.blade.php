@extends('layouts.public')

@section('title', $lowongan->nama_lowongan)

@section('content')

<nav class="breadcrumb-wrapper">
    <a href="{{ route('public.home') }}">Beranda</a>
    <span>/</span>
    <a href="{{ route('jobs.index') }}">Lowongan</a>
    <span>/</span>
    <span class="active">{{ $lowongan->nama_lowongan }}</span>
</nav>

<section class="jobs-detail py-5">
    <div class="container">

        <div class="job-detail-header">
            <div class="job-detail-left">

                <div class="company-logo">
                    <i class="bi bi-building"></i>
                </div>

                <div class="job-detail-info">
                    <h3 class="job-title">{{ $lowongan->nama_lowongan }}</h3>

                    <ul class="job-meta-list">
                        <li><i class="bi bi-building"></i> {{ $lowongan->penempatan ?? 'Perusahaan Mitra' }}</li>
                        <li><i class="bi bi-cash"></i>
                            Rp {{ number_format($lowongan->gaji_min) }}
                            –
                            {{ number_format($lowongan->gaji_max) }}
                        </li>
                        <li><i class="bi bi-clock"></i>
                            {{ ucfirst(str_replace('_',' ',$lowongan->tipe_kerja)) }}
                            · {{ ucfirst($lowongan->sistem_kerja) }}
                        </li>
                        <li><i class="bi bi-mortarboard"></i>
                            Minimal {{ $lowongan->pendidikan_minimal }}
                        </li>
                        <li><i class="bi bi-geo-alt"></i> {{ $lowongan->lokasi }}</li>
                    </ul>

                    <div class="mt-4">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-secondary">
                            Login untuk Melamar
                        </a>

                    @else

                        @if(auth()->user()->role !== 'pelamar')
                            <button class="btn btn-secondary" disabled>
                                Hanya Pelamar yang Bisa Melamar
                            </button>

                        @elseif(!auth()->user()->isProfileComplete())
                            <button class="btn btn-warning" disabled
                                title="Lengkapi Data Diri, Tentang Saya, Pendidikan, Skills, dan Resume">
                                Lengkapi Profil
                            </button>

                        @elseif($application && $application->status === 'diterima')
                            <button class="btn btn-success" disabled>
                                Anda Sudah Diterima
                            </button>

                        @elseif($application && $application->status !== 'ditolak')
                            <button class="btn btn-secondary" disabled>
                                Lamaran Sedang Diproses
                            </button>

                        @else
                            {{-- BOLEH MELAMAR --}}
                            <form method="POST" action="{{ route('pelamar.lamar.store', $lowongan->id) }}">
                                @csrf
                                <button class="btn btn-primary">
                                    Lamar
                                </button>
                            </form>
                        @endif

                    @endguest
                </div>

                </div>
            </div>
        </div>

        <hr class="my-5">

        <div class="row">

            <div class="col-md-6">
                <h5 class="fw-bold mb-3">Persyaratan</h5>
                <ul class="job-list">
                    <li>{{ ucfirst($lowongan->sistem_kerja) }}</li>
                    <li>{{ $lowongan->pendidikan_minimal }}</li>
                    @if(!$lowongan->tanpa_batas_usia)
                        <li>Usia {{ $lowongan->usia_min }} – {{ $lowongan->usia_max }} tahun</li>
                    @endif
                    <li>{{ ucfirst($lowongan->jenis_kelamin ?? 'Semua') }}</li>
                </ul>
            </div>

            <div class="col-md-6">
                <h5 class="fw-bold mb-3">Deskripsi Pekerjaan</h5>
                <p class="text-muted">
                    {!! nl2br(e($lowongan->deskripsi_pekerjaan)) !!}
                </p>
            </div>
        </div>

        {{-- SKILLS --}}
        <div class="mt-5">
            <h5 class="fw-bold mb-3">Skills yang Dibutuhkan</h5>

            @if ($lowongan->skills->count())
                <ul class="job-list">
                    @foreach ($lowongan->skills as $skill)
                        <li>{{ $skill->nama_skill }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">Tidak ada skill khusus.</p>
            @endif
        </div>


    </div>
</section>
@endsection
