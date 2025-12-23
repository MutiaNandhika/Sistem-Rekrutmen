@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

@php
    $jasa = [
    [
        'id' => 'driver',
        'title' => 'Ride-Hailing Driver',
        'icon' => 'bi-car-front-fill',
        'items' => [
            'Antar jemput penumpang tepat waktu',
            'Menjaga kenyamanan dan keselamatan perjalanan',
            'Merawat kendaraan agar tetap layak jalan',
            'Mengikuti standar pelayanan pelanggan',
        ]
    ],
    [
        'id' => 'manufacture',
        'title' => 'Manufacture',
        'icon' => 'bi-gear-wide-connected',
        'items' => [
            'Mengoperasikan mesin produksi',
            'Pengecekan kualitas produk',
            'Proses pengemasan dan distribusi',
            'Menjaga kebersihan area kerja',
        ]
    ],
    [
        'id' => 'security',
        'title' => 'Security & Building Management',
        'icon' => 'bi-shield-check',
        'items' => [
            'Menjaga keamanan area gedung',
            'Patroli dan pencatatan aktivitas',
            'Membantu tamu dan penghuni',
            'Memastikan fasilitas berfungsi optimal',
        ]
    ],
    [
        'id' => 'courier',
        'title' => 'Courier',
        'icon' => 'bi-box-seam',
        'items' => [
            'Mengambil dan mengirim paket',
            'Menjaga kondisi barang',
            'Pencatatan pengiriman',
            'Koordinasi dengan pelanggan',
        ]
    ],
    [
        'id' => 'trucking',
        'title' => 'Trucking Driver',
        'icon' => 'bi-truck',
        'items' => [
            'Mengangkut barang sesuai rute',
            'Memastikan barang aman',
            'Cek kendaraan sebelum berangkat',
            'Melaporkan kondisi perjalanan',
        ]
    ],
    [
        'id' => 'technician',
        'title' => 'Technician',
        'icon' => 'bi-tools',
        'items' => [
            'Pemeriksaan sistem teknis',
            'Perbaikan dan perawatan',
            'Menjaga performa mesin',
            'Pelaporan rutin',
        ]
    ],
    [
        'id' => 'gardener',
        'title' => 'Gardener',
        'icon' => 'bi-flower1',
        'items' => [
            'Perawatan rutin taman dan tanaman hias',
            'Pemangkasan dan penyiraman',
            'Penanggulangan hama tanaman',
            'Pemeliharaan lanskap',
        ]
    ],
    [
        'id' => 'pest',
        'title' => 'Pest Control',
        'icon' => 'bi-bug',
        'items' => [
            'Tenaga pest control bersertifikasi',
            'Penanganan tikus, serangga, rayap',
            'Fogging dan fumigasi',
            'Inspeksi berkala',
        ]
    ],
    [
        'id' => 'gondola',
        'title' => 'Gondola',
        'icon' => 'bi-building',
        'items' => [
            'Operator gondola bersertifikat K3',
            'Pembersihan gedung bertingkat',
            'Inspeksi unit gondola',
            'Prosedur keselamatan kerja',
        ]
    ],
    [
        'id' => 'cleaning',
        'title' => 'Cleaning Service',
        'icon' => 'bi-droplet-half',
        'items' => [
            'Pembersihan area umum',
            'Deep cleaning berkala',
            'Pengelolaan sampah',
            'Penggunaan chemical sesuai standar',
        ]
    ],
    [
        'id' => 'driver_office',
        'title' => 'Driver Kantoran',
        'icon' => 'bi-car-front',
        'items' => [
            'Pengemudi direksi',
            'Pengemudi operasional',
            'Pengemudi kendaraan dinas',
            'Antar jemput pegawai',
        ]
    ],
    [
        'id' => 'front_office',
        'title' => 'Front Office',
        'icon' => 'bi-person-badge',
        'items' => [
            'Resepsionis',
            'Penerima tamu',
            'Pengelolaan buku tamu',
            'Penanganan telepon',
        ]
    ],
];

    $clients = [
        ['name' => 'Client A', 'logo' => 'client1.png'],
        ['name' => 'Client B', 'logo' => 'client2.png'],
        ['name' => 'Client C', 'logo' => 'client3.png'],
        ['name' => 'Client D', 'logo' => 'client4.png'],
        ['name' => 'Client E', 'logo' => 'client5.png'],
        ['name' => 'Client F', 'logo' => 'client6.png'],
    ];

    $areas = [
        'Jabodetabek', 'Bandung', 'Cirebon', 'Semarang',
        'Yogyakarta', 'Surabaya', 'Malang', 'Denpasar',
    ];
@endphp

{{-- HERO --}}
<section class="py-5">
    <div class="container">
        <div class="hero-box">

            {{-- CONTENT WRAPPER (WAJIB) --}}
            <div class="hero-content">
                <div class="row align-items-center">
                    <div class="col-lg-8">

                        <h1 class="hero-title">
                            Bergabung Bersama MDA Partner dan Raih Karier Impianmu
                        </h1>

                        <p class="hero-desc">
                            Kami hadir sebagai mitra terpercaya dalam menyediakan tenaga kerja
                            berkualitas untuk berbagai perusahaan.
                        </p>

                        {{-- HERO BUTTON --}}
                        <div class="hero-actions">
                            <a href="{{ route('jobs.index') }}"
                               class="btn btn-cta-primary">
                                Lihat Lowongan
                            </a>

                            <a href="https://katalog.inaproc.id/"
                               target="_blank"
                               rel="noopener"
                               class="btn btn-cta-secondary">
                                Kunjungi Katalog Kami
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            {{-- END CONTENT WRAPPER --}}

        </div>
    </div>
</section>

{{-- TENTANG KAMI --}}
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-4">

            <div class="col-lg-4 text-center">
                <img src="{{ asset('images/mda-logo.png') }}"
                     alt="MDA Partner"
                     class="img-fluid"
                     style="max-height: 80px;">
            </div>

            <div class="col-lg-8">
                <p class="text-muted mb-2">
                    Mitra Daska Anarwata (MDA) adalah penyedia tenaga kerja dan outsourcing
                    berkomitmen untuk memberikan solusi ketenagakerjaan yang inovatif dan efisien.
                </p>

                <p class="text-muted mb-0">
                    Kami membantu perusahaan fokus pada bisnis inti tanpa terbebani oleh
                    kerumitan manajemen SDM, serta membantu pencari kerja menemukan
                    peluang terbaik sesuai kompetensi mereka.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- LAYANAN --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="fw-bold">
                Layanan dari <span class="text-danger">MDA Partner</span>
            </h3>
            <p class="text-muted mt-2">
                Kami menyediakan layanan terbaik untuk memenuhi kebutuhan SDM Anda.
            </p>
        </div>

        <div class="row g-4">
            {{-- CARD --}}
            <div class="col-md-6 col-lg-3">
                <div class="service-card h-100">
                    <div class="service-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <h6 class="service-title">Layanan Rekrutmen</h6>

                    <p class="service-desc">
                        Kami siap membantu dalam perekrutan talenta terbaik sesuai kebutuhan Anda.
                        Proses kami mencakup seluruh tahapan rekrutmen hingga pasca penempatan.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="service-card h-100">
                    <div class="service-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                    <h6 class="service-title">Administrasi Penggajian</h6>

                    <p class="service-desc">
                        Mengelola penggajian, pajak, dan pelaporan secara akurat agar perusahaan
                        fokus pada bisnis utama.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="service-card h-100">
                    <div class="service-icon">
                        <i class="bi bi-gear-fill"></i>
                    </div>

                    <h6 class="service-title">Outsourcing Proses</h6>

                    <p class="service-desc">
                        Penyerahan fungsi non-inti kepada tenaga profesional berpengalaman
                        untuk efisiensi operasional.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="service-card h-100">
                    <div class="service-icon">
                        <i class="bi bi-laptop-fill"></i>
                    </div>

                    <h6 class="service-title">Manajemen HR Digital</h6>

                    <p class="service-desc">
                        Platform HR digital untuk absensi, cuti, kinerja, dan data karyawan
                        secara terintegrasi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ANEKA JASA --}}
{{-- ANEKA JASA --}}
<section class="py-5 bg-light">
    <div class="container">

        <div class="text-center mb-5">
            <h4 class="fw-bold">
                <span class="text-danger">MDA Partner</span> Menyediakan Aneka Jasa
            </h4>
            <p class="text-muted">
                Kami menawarkan berbagai jasa untuk memenuhi kebutuhan SDM Anda.
            </p>
        </div>

        {{-- STATE DI LEVEL GRID --}}
        <div class="row g-4" x-data="{ active: null }">

            @foreach ($jasa as $item)
                <div class="col-md-6 col-lg-4">

                    <div class="jasa-card shadow-sm d-flex flex-column"
                    :class="{ 'is-open': active === '{{ $item['id'] }}' }">

                        {{-- BODY --}}
                        <div class="p-4 jasa-body flex-grow-1">
                            {{-- ICON --}}
                            <div class="jasa-icon">
                                <i class="bi {{ $item['icon'] }}"></i>
                            </div>

                            {{-- TITLE --}}
                            <h6 class="jasa-title mb-3">
                                {{ $item['title'] }}
                            </h6>

                            {{-- DETAIL --}}
                            <div
                                x-show="active === '{{ $item['id'] }}'"
                                x-collapse
                                class="jasa-detail"
                            >
                                <ul class="jasa-list">
                                    @foreach ($item['items'] as $desc)
                                        <li>{{ $desc }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{-- BUTTON --}}
                        <button
                            type="button"
                            class="jasa-btn"
                            :class="{ 'open': active === '{{ $item['id'] }}' }"
                            @click="
                                active === '{{ $item['id'] }}'
                                    ? active = null
                                    : active = '{{ $item['id'] }}'
                            "
                        >
                            <span
                                x-text="
                                    active === '{{ $item['id'] }}'
                                        ? 'Tutup'
                                        : 'Lihat Layanan'
                                "
                            ></span>

                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                <path d="M6 9L12 15L18 9"
                                      stroke="white"
                                      stroke-width="2"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"/>
                            </svg>
                        </button>

                    </div>

                </div>
            @endforeach

        </div>
    </div>
</section>


{{-- KLIEN KAMI (BANNER STYLE) --}}
<section class="client-banner my-5">
    <div class="container-fluid px-0">
        <div class="client-banner-inner">

            {{-- HEADER --}}
            <div class="container">
                <div class="row align-items-center mb-4">
                    <div class="col-md-6">
                        <h3 class="fw-bold text-white mb-0">Klien Kami</h3>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="text-white-75 mb-0">
                            MDA Partner telah bekerja sama dengan klien untuk hasil yang terbaik.
                            Sekarang giliran Anda!
                        </p>
                    </div>
                </div>

                {{-- LOGO --}}
                <div class="row g-4 justify-content-center">
                    @foreach ($clients as $client)
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="client-logo-dark">
                                <img
                                    src="{{ asset('images/clients/' . $client['logo']) }}"
                                    alt="{{ $client['name'] }}"
                                >
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>
    </div>
</section>


{{-- JANGKAUAN AREA --}}
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-md-6">
                <h4 class="fw-bold mb-3">
                    Jangkauan Area <span class="text-danger">MDA Partner</span>
                </h4>

                <p class="text-muted mb-4">
                    Kami hadir untuk memenuhi kebutuhan SDM Anda di berbagai wilayah Indonesia.
                </p>

                <div class="row g-3">
                    @foreach ($areas as $area)
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-danger">●</span>
                                <span class="small fw-medium">{{ $area }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-6 text-center">
                <div class="area-visual">
                    <img src="{{ asset('images/area-indonesia.png') }}"
                         alt="Jangkauan Area"
                         class="img-fluid">
                </div>
            </div>

        </div>
    </div>
</section>

<section class="cta-big-section py-5">
    <div class="container">
        <div class="cta-big-box text-center">

            <h2 class="cta-title mb-3">
                Butuh solusi cepat untuk kebutuhan SDM?
            </h2>

            <p class="cta-desc mb-4">
                <strong>MDA Partner</strong> siap membantu perusahaan Anda
                menemukan tenaga kerja terbaik.
            </p>

            <div class="cta-actions">
                {{-- BUTTON LOWONGAN --}}
                <a href="{{ route('jobs.index') }}"
                   class="btn btn-cta-primary">
                    Lihat Lowongan
                </a>

                {{-- BUTTON KATALOG --}}
                <a href="https://katalog.inaproc.id/"
                   target="_blank"
                   rel="noopener"
                   class="btn btn-cta-secondary">
                    Kunjungi Katalog Kami
                </a>
            </div>

        </div>
    </div>
</section>

@endsection
