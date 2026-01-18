@extends('layouts.pelamar')

@section('title', 'Lamaran Saya')

@section('content')

<h4 class="lamaran-title">Lamaran Saya</h4>

@if(!$application)
    <div class="alert alert-info">
        Kamu belum memiliki lamaran aktif.
    </div>
@else

@php
    $status = $application->status;
@endphp

<div class="lamaran-wrapper">
    <div class="lamaran-timeline">

        {{-- ================= 1. DIPROSES ================= --}}
        <div class="timeline-item active">
            <div class="timeline-dot">1</div>
            <div class="timeline-content">
                <h6>DIPROSES</h6>
                <div class="timeline-info">
                    Lamaranmu sudah kami terima dan sedang ditinjau.
                </div>
            </div>
        </div>

        {{-- ================= 2. SCREENING ================= --}}
        <div class="timeline-item {{ in_array($status, ['screening','seleksi','interview','offer','diterima']) ? 'active' : '' }}">
            <div class="timeline-dot">2</div>
            <div class="timeline-content">
                <h6>SCREENING</h6>

                @if($status === 'screening')
                    <div class="timeline-info">
                        Berkas administrasi sedang diperiksa oleh HRD.
                    </div>
                @elseif(in_array($status, ['seleksi','interview','offer','diterima']))
                    <div class="timeline-info">
                        Screening administrasi telah dilalui.
                    </div>
                @else
                    <div class="timeline-info">Menunggu proses.</div>
                @endif
            </div>
        </div>

        {{-- ================= 3. SELEKSI ================= --}}
        <div class="timeline-item {{ in_array($status, ['seleksi','interview','offer','diterima']) ? 'active' : '' }}">
            <div class="timeline-dot">3</div>
            <div class="timeline-content">
                <h6>SELEKSI</h6>

                @if($status === 'seleksi')
                    <div class="timeline-info">
                        Kamu lolos administrasi dan sedang dalam seleksi lanjutan.
                    </div>
                @elseif(in_array($status, ['interview','offer','diterima']))
                    <div class="timeline-info">
                        Tahap seleksi telah dilalui.
                    </div>
                @else
                    <div class="timeline-info">Menunggu proses.</div>
                @endif
            </div>
        </div>

        {{-- ================= 4. INTERVIEW ================= --}}
        <div class="timeline-item {{ in_array($status, ['interview','offer','diterima']) ? 'active' : '' }}">
            <div class="timeline-dot">4</div>
            <div class="timeline-content">
                <h6>INTERVIEW</h6>

                @if($application->interview_at)
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

        {{-- ================= 5. OFFER ================= --}}
        <div class="timeline-item {{ in_array($status, ['offer','diterima','ditolak']) ? 'active' : '' }}">
            <div class="timeline-dot">5</div>
            <div class="timeline-content">
                <h6>OFFER</h6>

                @if($status === 'offer')
                    <div class="timeline-info mb-2">
                        Penawaran kerja telah dikirim.
                    </div>

                    <a href="{{ $application->offer_file }}"
                       target="_blank"
                       class="btn btn-outline-primary btn-sm mb-2">
                        📄 Lihat Offering Letter
                    </a>

                    <div class="d-flex gap-2">
                        <form method="POST" action="{{ route('pelamar.offer.response', $application) }}">
                            @csrf
                            <input type="hidden" name="response" value="diterima">
                            <button class="btn btn-success btn-sm">Terima</button>
                        </form>

                        <form method="POST" action="{{ route('pelamar.offer.response', $application) }}">
                            @csrf
                            <input type="hidden" name="response" value="ditolak">
                            <button class="btn btn-danger btn-sm">Tolak</button>
                        </form>
                    </div>

                @elseif($status === 'diterima')
                    <div class="alert alert-success mt-2">
                        🎉 Selamat! Kamu diterima bekerja.
                    </div>

                @elseif($status === 'ditolak')
                    <div class="alert alert-danger mt-2">
                        Lamaran telah berakhir.
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endif

@endsection
