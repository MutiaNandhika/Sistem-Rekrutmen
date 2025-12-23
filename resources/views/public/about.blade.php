@extends('layouts.public')

@section('title', 'Tentang Kami')

@section('content')
<section class="about-section py-5">
    <div class="container">

        <div class="row align-items-center g-5">

            {{-- LEFT CONTENT --}}
            <div class="col-lg-7">
                <h1 class="about-title mb-4">
                    Tentang Kami
                </h1>

                <p class="about-text">
                    <strong>Mitra Daksas Akarwasta (MDA)</strong> adalah penyedia tenaga kerja
                    dan outsourcing yang didirikan pada tahun <strong>2025</strong> di Bandung.
                    Tujuan kami adalah menjadi mitra strategis dalam membantu kebutuhan
                    perusahaan akan SDM yang berkualitas dan kompeten.
                </p>

                <p class="about-text">
                    Kami berkomitmen untuk menyediakan solusi ketenagakerjaan yang inovatif
                    dan efisien, membantu perusahaan agar dapat fokus pada bisnis inti
                    sehingga menghasilkan produktivitas dan efisiensi yang maksimal.
                </p>

                <p class="about-text mb-0">
                    Dengan dukungan tim profesional yang kompeten dan standar industri,
                    kami siap mendukung pertumbuhan dan keberlangsungan bisnis dengan
                    menyediakan tenaga kerja yang tepat.
                </p>
            </div>

            {{-- RIGHT LOGO --}}
            <div class="col-lg-5 text-center">
                <img src="{{ asset('images/mda-logo.png') }}"
                     alt="MDA Partner"
                     class="about-logo img-fluid">
            </div>
{{-- VISI & MISI --}}
<section class="vision-mission-section py-5">
    <div class="container">

        {{-- VISI --}}
        <div class="row align-items-center g-5 mb-5">

            <div class="col-lg-4 text-center">
                <div class="vm-image vm-left">
                    <img src="{{ asset('images/vision.png') }}"
                         alt="Visi MDA Partner"
                         class="img-fluid">
                </div>
            </div>

            <div class="col-lg-8">
                <h3 class="vm-title">
                    Visi <span>MDA Partner</span>
                </h3>

                <p class="vm-text">
                    Menjadi partner strategis yang memberikan solusi tenaga kerja
                    profesional dan inovatif untuk mendukung pertumbuhan serta
                    keberlangsungan bisnis di berbagai industri.
                </p>
            </div>

        </div>

        {{-- MISI --}}
        <div class="row align-items-center g-5 flex-lg-row-reverse">

            <div class="col-lg-4 text-center">
                <div class="vm-image vm-right">
                    <img src="{{ asset('images/mission.png') }}"
                         alt="Misi MDA Partner"
                         class="img-fluid">
                </div>
            </div>

            <div class="col-lg-8">
                <h3 class="vm-title">
                    Misi <span>MDA Partner</span>
                </h3>

                <ul class="vm-list">
                    <li>Menyediakan SDM berkualitas dan kompeten sesuai kebutuhan industri.</li>
                    <li>Memberikan layanan ketenagakerjaan yang efisien, inovatif, dan berorientasi pada klien.</li>
                    <li>Mendukung pertumbuhan karir fokus pada tim bisnis melalui pengelolaan SDM yang profesional.</li>
                </ul>
            </div>

        </div>

    </div>
</section>

        </div>

    </div>
</section>
@endsection
