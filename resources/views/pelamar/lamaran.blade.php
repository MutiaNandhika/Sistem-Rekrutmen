@extends('layouts.pelamar')

@section('title', 'Lamaran Saya')

@section('content')

<h4 class="lamaran-title">Lamaran Saya</h4>

<div class="lamaran-wrapper">

    <div class="lamaran-timeline">

        {{-- STEP 1 --}}
        <div class="timeline-item active">
            <div class="timeline-dot">1</div>
            <div class="timeline-content">
                <h6>DIPROSES</h6>
                <div class="timeline-info">
                    Lamaranmu sudah kami terima dan sedang dalam proses peninjauan awal.
                </div>
            </div>
        </div>

        {{-- STEP 2 --}}
        <div class="timeline-item active">
            <div class="timeline-dot">2</div>
            <div class="timeline-content">
                <h6>SCREENING</h6>
                <div class="timeline-info">
                    Tim HR sedang menilai CV dan kualifikasimu.
                </div>
            </div>
        </div>

        {{-- STEP 3 --}}
        <div class="timeline-item active">
            <div class="timeline-dot">3</div>
            <div class="timeline-content">
                <h6>INTERVIEW</h6>
                <div class="timeline-info">
                    Kamu lolos screening dan sedang menjalani proses interview.
                </div>

                <div class="timeline-box">
                    <strong>Wawancara:</strong> Online<br>
                    <strong>Hari, Tanggal:</strong> Sabtu, 20 Desember 2025<br>
                    <strong>Jam:</strong> 10.00 – 10.30<br>
                    <strong>Link:</strong>
                    <a href="#" target="_blank">www.kajshahhdad.com</a>
                </div>
            </div>
        </div>

        {{-- STEP 4 --}}
        <div class="timeline-item active">
            <div class="timeline-dot">4</div>
            <div class="timeline-content">
                <h6>OFFER</h6>
                <div class="timeline-info">
                    Penawaran kerja telah dikirim dan menunggu keputusanmu.
                </div>

                <div class="timeline-box">
                    <strong>Offering Letter</strong><br>
                    Silakan unduh dan baca dokumen penawaran dengan saksama.
                </div>

                <div class="timeline-actions">
                    <button class="btn btn-primary btn-sm">Terima Tawaran</button>
                    <button class="btn btn-danger btn-sm">Tolak Tawaran</button>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
