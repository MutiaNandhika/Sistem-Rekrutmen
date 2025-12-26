@extends('layouts.hrd')

@section('title', 'Detail Kandidat')

{{-- BREADCRUMB --}}
@section('breadcrumb')
<nav class="breadcrumb-wrapper">
    <a href="{{ route('lowongan.index') }}">Lowongan</a>
    <span>/</span>
    <a href="{{ route('hrd.kandidat.index', $lowongan) }}">Kelola Kandidat</a>
    <span>/</span>
    <span class="active">Detail Kandidat</span>
</nav>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Detail Kandidat</h4>

    <a href="{{ route('hrd.kandidat.index', $lowongan) }}"
       class="btn btn-light border">
        ← Kembali ke Kandidat
    </a>
</div>

<div class="row g-4">

    {{-- ================= LEFT : PROFILE ================= --}}
    <div class="col-lg-7">

        {{-- PROFILE CARD --}}
        <div class="card shadow-sm mb-4">
    <div class="card-body d-flex gap-4 align-items-start">

        <div class="avatar-lg text-muted">
            <i class="bi bi-person-circle fs-1"></i>
        </div>

        <div class="flex-grow-1">
            <h5 class="fw-bold mb-1">Mutia Nandhika</h5>
            <span class="badge bg-info-subtle text-dark mb-3">
                Kandidat Aktif
            </span>

            <div class="row small text-muted mt-3">
                <div class="col-6 mb-2"><strong>WhatsApp</strong><br>081234567890</div>
                <div class="col-6 mb-2"><strong>Email</strong><br>mutianandhika@gmail.com</div>
                <div class="col-6 mb-2"><strong>Lokasi</strong><br>Jakarta</div>
                <div class="col-6 mb-2"><strong>Usia</strong><br>21</div>
                <div class="col-6 mb-2"><strong>Pendidikan</strong><br>SMA / SMK</div>
                <div class="col-6 mb-2"><strong>Jenis Kelamin</strong><br>Perempuan</div>
            </div>
        </div>

    </div>
</div>


        {{-- SECTIONS (READ ONLY) --}}
        {{-- ================= DETAIL INFORMASI KANDIDAT ================= --}}

{{-- TENTANG SAYA --}}
<div class="mb-4">
    <h6 class="fw-bold text-uppercase small">Tentang Saya</h6>
    <hr class="my-2">
    <p class="text-muted mb-0">
        Saya adalah individu yang bertanggung jawab, mudah beradaptasi, dan memiliki
        semangat belajar yang tinggi. Saya terbiasa bekerja secara mandiri maupun dalam tim,
        serta memiliki ketertarikan besar untuk berkembang di bidang profesional.
    </p>
</div>

{{-- PENGALAMAN KERJA --}}
<div class="mb-4">
    <h6 class="fw-bold text-uppercase small">Pengalaman Kerja</h6>
    <hr class="my-2">
    <p class="text-muted mb-1">
        <strong>Staff Administrasi</strong> – PT Sukses Makmur (2022 – 2024)
    </p>
    <ul class="text-muted small ps-3 mb-0">
        <li>Mengelola data administrasi dan dokumen perusahaan</li>
        <li>Membantu koordinasi antar divisi</li>
        <li>Menyusun laporan harian dan bulanan</li>
    </ul>
</div>

{{-- PENDIDIKAN --}}
<div class="mb-4">
    <h6 class="fw-bold text-uppercase small">Pendidikan</h6>
    <hr class="my-2">
    <p class="text-muted mb-0">
        <strong>SMA Negeri 5 Jakarta</strong><br>
        Jurusan IPS (2018 – 2021)
    </p>
</div>

{{-- SKILLS --}}
<div class="mb-4">
    <h6 class="fw-bold text-uppercase small">Skills</h6>
    <hr class="my-2">
    <div class="d-flex flex-wrap gap-2">
        <span class="badge bg-light text-dark border">Microsoft Word</span>
        <span class="badge bg-light text-dark border">Microsoft Excel</span>
        <span class="badge bg-light text-dark border">Komunikasi</span>
        <span class="badge bg-light text-dark border">Manajemen Waktu</span>
        <span class="badge bg-light text-dark border">Kerja Tim</span>
    </div>
</div>

{{-- RESUME --}}
<div class="mb-4">
    <h6 class="fw-bold text-uppercase small">Resume</h6>
    <hr class="my-2">
    <a href="#" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-file-earmark-text"></i> Lihat Resume
    </a>
</div>

{{-- PENGHARGAAN --}}
<div class="mb-4">
    <h6 class="fw-bold text-uppercase small">Penghargaan</h6>
    <hr class="my-2">
    <ul class="text-muted small ps-3 mb-0">
        <li>Karyawan Terbaik Bulanan – PT Sukses Makmur (2023)</li>
    </ul>
</div>

{{-- SERTIFIKAT --}}
<div class="mb-4">
    <h6 class="fw-bold text-uppercase small">Sertifikat</h6>
    <hr class="my-2">
    <ul class="text-muted small ps-3 mb-0">
        <li>Sertifikat Administrasi Perkantoran – BNSP</li>
        <li>Sertifikat Microsoft Office Dasar</li>
    </ul>
</div>

{{-- ORGANISASI --}}
<div class="mb-4">
    <h6 class="fw-bold text-uppercase small">Pengalaman Organisasi & Relawan</h6>
    <hr class="my-2">
    <p class="text-muted mb-0">
        Anggota OSIS SMA Negeri 5 Jakarta sebagai Sekretaris,
        bertanggung jawab dalam pengelolaan administrasi kegiatan sekolah.
    </p>
</div>



    </div>

    {{-- ================= RIGHT : TRACKING ================= --}}
    <div class="col-lg-5">

        <div class="card shadow-sm">
            <div class="card-body">

                <h6 class="fw-bold mb-4">Tracking Lamaran</h6>
                <p class="text-muted small mb-3">
                    Pantau progres kandidat dari awal hingga penawaran kerja.
                </p>

                <ul class="timeline">

                    {{-- STEP 1 --}}
                    <li class="active">
                        <span class="step">1</span>
                        <div>
                            <strong>Diproses</strong>
                            <div class="mt-2">
                                <button class="btn btn-sm btn-danger">Tidak Lolos</button>
                                <button class="btn btn-sm btn-success">Lolos</button>
                            </div>
                        </div>
                    </li>

                    {{-- STEP 2 --}}
                    <li class="active">
                        <span class="step">2</span>
                        <div>
                            <strong>Screening</strong>
                            <div class="mt-2">
                                <button class="btn btn-sm btn-danger">Tidak Lolos</button>
                                <button class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalInterview">
                                    Atur Jadwal Interview
                                </button>

                            </div>
                        </div>
                    </li>

                    {{-- STEP 3 --}}
                    <li>
                        <span class="step">3</span>
                        <div>
                            <strong>Interview</strong>

                            <div class="alert alert-light mt-2 small">
                                <strong>Wawancara:</strong> Online <br>
                                <strong>Hari:</strong> Sabtu, 20 Des 2025 <br>
                                <strong>Jam:</strong> 10.00 – 10.30 <br>
                                <strong>Link:</strong> zoom.us/xxxxx
                            </div>

                            <button class="btn btn-sm btn-danger">Tidak Lolos</button>
                            <button class="btn btn-sm btn-primary">Buat Tawaran</button>
                        </div>
                    </li>

                    {{-- STEP 4 --}}
                    <li>
                        <span class="step">4</span>
                        <div>
                            <strong>Offer</strong>
                            <div class="text-muted small">Tawaran diterima</div>
                        </div>
                    </li>

                </ul>

            </div>
        </div>

    </div>

</div>

@endsection

{{-- ================= MODAL JADWAL INTERVIEW ================= --}}
<div class="modal fade" id="modalInterview" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">

            <div class="modal-body p-4">

                <h5 class="fw-bold mb-4">Jadwal Interview</h5>

                {{-- PILIH METODE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Metode</label>
                    <select class="form-select">
                        <option selected>Online</option>
                        <option>Offline</option>
                        <option>Telepon</option>
                    </select>
                </div>

                {{-- HARI & TANGGAL --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Hari, Tanggal</label>
                    <input type="date" class="form-control">
                </div>

                {{-- JAM --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Jam</label>
                    <input type="time" class="form-control">
                </div>

                {{-- LINK --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Link Wawancara</label>
                    <input type="text"
                           class="form-control"
                           placeholder="https://zoom.us/xxxx">
                </div>

                {{-- ACTION --}}
                <div class="d-flex justify-content-end gap-3">
                    <button class="btn btn-danger px-4"
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button class="btn btn-primary px-4">
                        Submit
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>
