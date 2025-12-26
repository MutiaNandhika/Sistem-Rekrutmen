@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<div class="admin-dashboard">
    <div class="container">

        <div class="row align-items-stretch">

            {{-- ================= LEFT (LOGO) ================= --}}
            <div class="col-lg-6 d-flex align-items-center">

                <div class="admin-logo-wrapper">
                    <img src="{{ asset('images/mda-logo.png') }}"
                         alt="MDA Partner"
                         class="admin-logo">
                </div>

            </div>

            {{-- ================= RIGHT (DESCRIPTION) ================= --}}
            <div class="col-lg-6">

                <div class="admin-description">
                    <p>
                        <strong>Mitra Daksa Anarawata (MDA)</strong> adalah penyedia
                        tenaga kerja dan outsourcing yang didirikan pada tahun 2025
                        di Bandung.
                    </p>

                    <p>
                        Tujuan kami adalah menjadi mitra strategis dalam membantu
                        kebutuhan perusahaan akan SDM yang berkualitas dan kompeten.
                    </p>

                    <p>
                        Kami berkomitmen menyediakan solusi ketenagakerjaan yang
                        inovatif dan efisien agar perusahaan dapat fokus pada bisnis inti.
                    </p>

                    <p>
                        Dengan dukungan tim profesional dan standar industri,
                        kami siap mendukung pertumbuhan dan keberlangsungan bisnis Anda.
                    </p>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection
