@extends('layouts.pelamar')

@section('title', 'Lamaran Saya')

@section('content')

<h4 class="lamaran-title">Lamaran Saya</h4>

@if(!$application)
    <div class="alert alert-info">
        Kamu belum memiliki lamaran aktif.
    </div>
@else

<div class="lamaran-wrapper">
    <div class="lamaran-timeline">

        {{-- ================= STEP 1 : DIPROSES ================= --}}
        <div class="timeline-item active">
            <div class="timeline-dot">1</div>
            <div class="timeline-content">
                <h6>DIPROSES</h6>
                <div class="timeline-info">
                    Lamaranmu sudah kami terima dan sedang dalam proses peninjauan awal.
                </div>
            </div>
        </div>

        {{-- ================= STEP 2 : SCREENING ================= --}}
        <div class="timeline-item {{ in_array($application->status, ['screening','interview','offer','diterima']) ? 'active' : '' }}">
            <div class="timeline-dot">2</div>
            <div class="timeline-content">
                <h6>SCREENING</h6>

                @if($application->status === 'screening')
                    <div class="timeline-info">
                        Tim HR sedang menilai CV dan kualifikasimu.
                    </div>
                @elseif(in_array($application->status, ['interview','offer','diterima']))
                    <div class="timeline-info">
                        Tahap screening telah dilewati.
                    </div>
                @else
                    <div class="timeline-info">
                        Menunggu proses.
                    </div>
                @endif
            </div>
        </div>

        {{-- ================= STEP 3 : INTERVIEW ================= --}}
        <div class="timeline-item {{ in_array($application->status, ['interview','offer','diterima']) ? 'active' : '' }}">
            <div class="timeline-dot">3</div>
            <div class="timeline-content">
                <h6>INTERVIEW</h6>

                @if($application->interview_at)
                    <div class="timeline-box">
                        <strong>Metode:</strong> {{ ucfirst($application->interview_method) }}<br>
                        <strong>Tanggal:</strong>
                        {{ $application->interview_at->translatedFormat('l, d F Y') }}

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

        {{-- ================= STEP 4 : OFFER ================= --}}
        <div class="timeline-item {{ in_array($application->status, ['offer','diterima','ditolak']) ? 'active' : '' }}">
            <div class="timeline-dot">4</div>
            <div class="timeline-content">
                <h6>OFFER</h6>

                @if($application->status === 'offer')
                    <div class="timeline-info mb-2">
                        Penawaran kerja telah dikirim dan menunggu keputusanmu.
                    </div>

                    <a href="{{ $application->offer_file }}"
                       target="_blank"
                       class="btn btn-outline-primary btn-sm mb-2">
                        📄 Lihat Offering Letter
                    </a>

                    <div class="d-flex gap-2">
                        <form method="POST"
                              action="{{ route('pelamar.offer.response', $application) }}">
                            @csrf
                            <input type="hidden" name="response" value="diterima">
                            <button class="btn btn-success btn-sm">
                                Terima Tawaran
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('pelamar.offer.response', $application) }}">
                            @csrf
                            <input type="hidden" name="response" value="ditolak">
                            <button class="btn btn-danger btn-sm">
                                Tolak Tawaran
                            </button>
                        </form>
                    </div>

                @elseif($application->status === 'diterima')
                    <div class="alert alert-success mt-2">
                        🎉 Selamat! Kamu menerima tawaran kerja.
                    </div>

                @elseif($application->status === 'ditolak')
                    <div class="alert alert-danger mt-2">
                        Lamaran ini telah berakhir.
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

@endif

@endsection
