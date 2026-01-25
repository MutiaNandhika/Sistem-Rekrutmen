@extends('layouts.pelamar')

@section('title', 'Lamaran Saya')

{{-- ================= BREADCRUMB ================= --}}
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

    $isRejected = in_array($status, [
        'ditolak',
        'ditolak_administrasi',
        'tidak_lolos_saw',
        'offer_ditolak',
    ]);

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
@endphp

<div class="card shadow-sm">
    <div class="card-body">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
            <div>
                <h5 class="mb-1">Tracking Lamaran</h5>
                <div class="text-muted small">
                    Posisi:
                    <strong>{{ $application->lowongan->nama_lowongan }}</strong>
                </div>
            </div>

            <span class="badge bg-{{ $badgeMap[$status] ?? 'secondary' }}">
                {{ strtoupper(str_replace('_',' ', $status)) }}
            </span>
        </div>

        <hr>

        {{-- INFO PENOLAKAN --}}
        @if($status === 'ditolak_administrasi')
            <div class="alert alert-danger">
                ❌ Lamaran kamu ditolak pada tahap <strong>administrasi</strong>.
            </div>
        @elseif($status === 'tidak_lolos_saw')
            <div class="alert alert-danger">
                ❌ Kamu tidak lolos pada tahap <strong>seleksi</strong>.
            </div>
        @elseif($status === 'offer_ditolak')
            <div class="alert alert-warning">
                ⚠️ Kamu menolak penawaran kerja (offering) dari perusahaan.
            </div>
        @elseif($status === 'ditolak')
            <div class="alert alert-danger">
                ❌ Kamu tidak lolos pada tahap <strong>interview</strong>.
            </div>
        @endif


        {{-- TIMELINE --}}
        <div class="lamaran-wrapper">
            <div class="lamaran-timeline">

                {{-- 1. DIPROSES --}}
                <div class="timeline-item active">
                    <div class="timeline-dot">1</div>
                    <div class="timeline-content">
                        <h6>DIPROSES</h6>
                        <div class="timeline-info">
                            Lamaranmu telah diterima oleh perusahaan.
                        </div>
                    </div>
                </div>

                {{-- 2. SCREENING --}}
                <div class="timeline-item {{ in_array($status, ['screening','seleksi','interview','offer','diterima','tidak_lolos_saw']) ? 'active' : '' }}">
                    <div class="timeline-dot">2</div>
                    <div class="timeline-content">
                        <h6>SCREENING</h6>

                        @if($status === 'screening')
                            <div class="timeline-info">
                                Berkas administrasi sedang diperiksa.
                            </div>
                        @elseif($status === 'ditolak_administrasi')
                            <div class="timeline-info text-danger">
                                Ditolak pada tahap administrasi.
                            </div>
                        @elseif(in_array($status, ['seleksi','interview','offer','diterima','tidak_lolos_saw']))
                            <div class="timeline-info">
                                Screening administrasi telah dilalui.
                            </div>
                        @else
                            <div class="timeline-info">Menunggu proses.</div>
                        @endif
                    </div>
                </div>

                {{-- 3. SELEKSI --}}
                <div class="timeline-item {{ in_array($status, ['seleksi','interview','offer','diterima']) ? 'active' : '' }}">
                    <div class="timeline-dot">3</div>
                    <div class="timeline-content">
                        <h6>SELEKSI</h6>

                        @if($status === 'seleksi')
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
                        @elseif(in_array($status, ['interview','offer','diterima']))
                            <div class="timeline-info">
                                Tahap seleksi telah dilalui.
                            </div>
                        @endif
                    </div>
                </div>
                {{-- 4. INTERVIEW --}}
                <div class="timeline-item {{ in_array($status, ['interview','offer','diterima']) ? 'active' : '' }}">
                    <div class="timeline-dot">4</div>
                    <div class="timeline-content">
                        <h6>INTERVIEW</h6>

                        @if($status === 'ditolak')
                            <div class="timeline-info text-danger">
                                Tidak lolos interview.
                            </div>
                        @elseif(in_array($status, ['ditolak_administrasi','tidak_lolos_saw']))
                            <div class="timeline-info text-muted">
                                Tahap interview tidak dilanjutkan.
                            </div>
                        @elseif($status === 'offer_ditolak')
                            <div class="timeline-info text-muted">
                                Interview telah dilalui.
                            </div>
                        @elseif($application->interview_at)
                            <div class="timeline-box">
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
                                Jadwal interview belum ditentukan.
                            </div>
                        @endif
                    </div>
                </div>
                {{-- 5. OFFER --}}
                <div class="timeline-item {{ in_array($status, ['offer','diterima','offer_ditolak']) ? 'active' : '' }}">
                    <div class="timeline-dot">5</div>
                    <div class="timeline-content">
                        <h6>OFFER</h6>

                        {{-- 📨 OFFER DIKIRIM --}}
                        @if($status === 'offer')
                            <div class="timeline-info mb-2">
                                Penawaran kerja telah dikirim oleh perusahaan.
                            </div>

                            <a href="{{ $application->offer_file }}"
                            target="_blank"
                            class="btn btn-outline-primary btn-sm mb-2">
                                📄 Lihat Offering Letter
                            </a>

                            {{-- ✅❌ TOMBOL RESPON (HANYA SAAT STATUS = OFFER) --}}
                            <div class="d-flex gap-2">
                                <form method="POST" action="{{ route('pelamar.offer.response', $application) }}">
                                    @csrf
                                    <input type="hidden" name="response" value="diterima">
                                    <button class="btn btn-success btn-sm">
                                        Terima Offer
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('pelamar.offer.response', $application) }}">
                                    @csrf
                                    <input type="hidden" name="response" value="ditolak">
                                    <button class="btn btn-danger btn-sm">
                                        Tolak Offer
                                    </button>
                                </form>
                            </div>

                        {{-- 🚫 OFFER DITOLAK OLEH PELAMAR --}}
                        @elseif($status === 'offer_ditolak')
                            <div class="timeline-info text-warning">
                                Kamu <strong>menolak penawaran kerja</strong> dari perusahaan.
                            </div>

                            <a href="{{ $application->offer_file }}"
                            target="_blank"
                            class="btn btn-outline-secondary btn-sm mt-2">
                                📄 Lihat Offering Letter
                            </a>

                        {{-- 🎉 OFFER DITERIMA --}}
                        @elseif($status === 'diterima')
                            <div class="alert alert-success mt-2">
                                🎉 Selamat! Kamu resmi <strong>diterima bekerja</strong>.
                            </div>

                        {{-- ⛔ OFFER TIDAK DILANJUTKAN --}}
                        @elseif(in_array($status, ['ditolak','ditolak_administrasi','tidak_lolos_saw']))
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

<style>
.lamaran-wrapper { max-width: 720px; }
.timeline-item { margin-bottom: 1.5rem; }
.timeline-content h6 { font-weight: 600; margin-bottom: .25rem; }
.timeline-info, .timeline-box {
    background: #f8f9fa;
    border-radius: 8px;
    padding: .75rem 1rem;
    font-size: .9rem;
}
</style>

@endsection
