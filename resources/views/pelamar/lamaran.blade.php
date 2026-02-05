@extends('layouts.pelamar')

@section('title', 'Lamaran Saya')

@section('breadcrumb')
<nav class="breadcrumb-wrapper">
    <a href="{{ route('pelamar.lamaran.index') }}">Lamaran Saya</a>
    <span>/</span>
    <span class="active">Tracking Lamaran</span>
</nav>
@endsection

@section('content')

@if(!$application)
    <div class="alert alert-info">
        Kamu belum memiliki lamaran aktif.
    </div>
@else

@php
    $status = $application->status;

    $badgeMap = [
        'diproses' => 'secondary',
        'screening' => 'info',
        'seleksi' => 'primary',
        'interview' => 'warning',
        'offer' => 'dark',
        'diterima' => 'success',
        'ditolak' => 'danger',
        'ditolak_administrasi' => 'danger',
        'tidak_lolos_saw' => 'danger',
        'offer_ditolak' => 'warning',
    ];

    $stepMap = [
        'diproses' => 1,
        'screening' => 2,
        'seleksi' => 3,
        'interview' => 4,
        'offer' => 5,
        'diterima' => 5,

        // gagal
        'ditolak_administrasi' => 2,
        'tidak_lolos_saw' => 3,
        'ditolak' => 4,
        'offer_ditolak' => 5,
    ];

    $currentStep = $stepMap[$status] ?? 1;
@endphp

<div class="card shadow-sm">
    <div class="card-body">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div>
                <h5 class="mb-1">Tracking Lamaran</h5>
                <div class="text-muted small">
                    Posisi: <strong>{{ $application->lowongan->nama_lowongan }}</strong>
                </div>
            </div>

            <span class="badge bg-{{ $badgeMap[$status] ?? 'secondary' }}">
                {{ strtoupper(str_replace('_',' ', $status)) }}
            </span>
        </div>

        <hr>

        {{-- ALERT GAGAL --}}
        @if($status === 'ditolak_administrasi')
            <div class="alert alert-danger">
                ❌ Lamaran kamu ditolak pada tahap <strong>administrasi</strong>.
            </div>
        @elseif($status === 'tidak_lolos_saw')
            <div class="alert alert-danger">
                ❌ Kamu tidak lolos pada tahap <strong>seleksi</strong>.
            </div>
        @elseif($status === 'ditolak')
            <div class="alert alert-danger">
                ❌ Kamu tidak lolos pada tahap <strong>interview</strong>.
            </div>
        @elseif($status === 'offer_ditolak')
            <div class="alert alert-warning">
                ⚠️ Kamu menolak penawaran kerja dari perusahaan.
            </div>
        @endif

        {{-- TIMELINE --}}
        <div class="lamaran-wrapper">
            <div class="lamaran-timeline">

                {{-- 1. DIPROSES --}}
                <div class="timeline-item {{ $currentStep >= 1 ? 'active' : '' }}">
                    <div class="timeline-dot">1</div>
                    <div class="timeline-content">
                        <h6>DIPROSES</h6>
                        <div class="timeline-info">
                            Lamaranmu telah diterima oleh perusahaan.
                        </div>
                    </div>
                </div>

                {{-- 2. SCREENING --}}
                <div class="timeline-item {{ $currentStep >= 2 ? 'active' : '' }}">
                    <div class="timeline-dot">2</div>
                    <div class="timeline-content">
                        <h6>SCREENING</h6>

                        @if($currentStep < 2)
                            {{-- tidak ada keterangan --}}
                        @elseif($status === 'screening')
                            <div class="timeline-info">
                                Berkas administrasi sedang diperiksa.
                            </div>
                        @elseif($status === 'ditolak_administrasi')
                            <div class="timeline-info text-danger">
                                Ditolak pada tahap administrasi.
                            </div>
                        @else
                            <div class="timeline-info">
                                Tahap screening telah dilalui.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- 3. SELEKSI --}}
                <div class="timeline-item {{ $currentStep >= 3 ? 'active' : '' }}">
                    <div class="timeline-dot">3</div>
                    <div class="timeline-content">
                        <h6>SELEKSI</h6>

                        @if($currentStep < 3)
                            {{-- tidak ada keterangan --}}
                        @elseif($status === 'seleksi')
                            <div class="timeline-info">
                                Kamu sedang dalam tahap seleksi lanjutan.
                            </div>
                        @elseif($status === 'tidak_lolos_saw')
                            <div class="timeline-info text-danger">
                                Tidak lolos seleksi.
                            </div>
                        @elseif($status === 'ditolak_administrasi')
                            <div class="timeline-info text-muted">
                                Tahap seleksi tidak dilanjutkan.
                            </div>
                        @else
                            <div class="timeline-info">
                                Tahap seleksi telah dilalui.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ================= 4. INTERVIEW ================= --}}
<div class="timeline-item {{ $currentStep >= 4 ? 'active' : '' }}">
    <div class="timeline-dot">4</div>
    <div class="timeline-content">
        <h6>INTERVIEW</h6>

        {{-- BELUM SAMPAI INTERVIEW --}}
        @if($currentStep < 4)
            {{-- tidak ada keterangan --}}

        {{-- GAGAL SEBELUM INTERVIEW --}}
        @elseif(in_array($status, ['ditolak_administrasi', 'tidak_lolos_saw']))
            <div class="timeline-info text-muted">
                Tahap interview tidak dilanjutkan.
            </div>

        {{-- TIDAK LOLOS INTERVIEW --}}
        @elseif($status === 'ditolak')
            <div class="timeline-info text-danger">
                Tidak lolos interview.
            </div>

        {{-- SEDANG / AKAN INTERVIEW --}}
        @elseif($status === 'interview')

            @if($application->interview_at)
                <div class="timeline-box">
                    <strong>Interview sedang berlangsung / dijadwalkan</strong><br><br>

                    <strong>Metode:</strong> {{ ucfirst($application->interview_method) }}<br>
                    <strong>Tanggal:</strong>
                    {{ $application->interview_at->translatedFormat('d F Y H:i') }}

                    @if($application->interview_link)
                        <br>
                        <strong>Link:</strong>
                        <a href="{{ $application->interview_link }}" target="_blank">
                            {{ $application->interview_link }}
                        </a>
                    @endif
                </div>
            @else
                <div class="timeline-info">
                    Menunggu penjadwalan interview dari perusahaan.
                </div>
            @endif

        {{-- INTERVIEW SUDAH DILALUI --}}
        @else
            <div class="timeline-info">
                Interview telah dilalui.
            </div>
        @endif

    </div>
</div>

                {{-- 5. OFFER --}}
                <div class="timeline-item {{ $currentStep >= 5 ? 'active' : '' }}">
                    <div class="timeline-dot">5</div>
                    <div class="timeline-content">
                        <h6>OFFER</h6>

                        @if($currentStep < 5)
                            {{-- tidak ada keterangan --}}
                        @elseif($status === 'offer')
                            <div class="timeline-info">
                                Penawaran kerja telah dikirim oleh perusahaan.
                            </div>
                        @elseif($status === 'offer_ditolak')
                            <div class="timeline-info text-warning">
                                Kamu menolak penawaran kerja.
                            </div>
                        @elseif($status === 'diterima')
                            <div class="alert alert-success mt-2">
                                🎉 Selamat! Kamu resmi diterima bekerja.
                            </div>
                        @else
                            <div class="timeline-info text-muted">
                                Proses tidak berlanjut ke tahap offer.
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endif
@endsection
