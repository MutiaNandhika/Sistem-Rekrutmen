@extends('layouts.public')

@section('title', 'Profile Saya')

@section('content')

{{-- ========================== PROFILE PAGE =============================== --}}

<div class="container py-5 profile-page">

    {{-- ========================= PROFILE CARD ============================ --}}

    <div class="profile-card mb-5">
        <div class="d-flex align-items-start gap-4">

            {{-- ================= AVATAR ================= --}}
            <div class="profile-avatar">
                <i class="bi bi-person"></i>
            </div>

            {{-- ================= USER INFO ================= --}}
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="fw-bold mb-3">Mutia Nandhika</h5>

                    <a href="#"
                       class="text-primary fw-semibold text-decoration-none"
                       data-bs-toggle="modal"
                       data-bs-target="#modalDataDiri">
                        <i class="bi bi-pencil-square"></i> Ubah data diri
                    </a>
                </div>

                {{-- ================= DETAIL ================= --}}
                <div class="row text-muted small">

                    <div class="col-md-6 mb-2">
                        <strong>WHATSAPP NUMBER</strong><br>
                        0812345678910
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>EMAIL</strong><br>
                        mutianandhika@gmail.com
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>LOKASI</strong><br>
                        Jakarta
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>USIA</strong><br>
                        21
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>PENDIDIKAN TERAKHIR</strong><br>
                        SMA / SMK
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>JENIS KELAMIN</strong><br>
                        Perempuan
                    </div>

                    <div class="col-md-12">
                        <strong>PENGALAMAN KERJA</strong><br>
                        Saya punya pengalaman kerja
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- ========================= TENTANG SAYA ============================ --}}

    <div class="cv-section mb-5">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="fw-bold text-uppercase mb-0">Tentang Saya</h6>

            <button
                class="btn btn-link text-primary fw-semibold p-0"
                data-bs-toggle="modal"
                data-bs-target="#modalTentangSaya">
                + Tambahkan
            </button>
        </div>

        {{-- OUTPUT TEXT --}}
        <p id="tentangSayaOutput" class="text-muted small mb-3">
            Jelaskan secara singkat kelebihanmu sehingga perusahaan yakin untuk merekrutmu.
        </p>

        <hr>
    </div>

    {{-- ================= PENGALAMAN KERJA ================= --}}
<div class="cv-section mb-5">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold text-uppercase mb-0">Pengalaman Kerja</h6>

        <button
            class="btn btn-link text-primary fw-semibold p-0"
            data-bs-toggle="modal"
            data-bs-target="#modalPengalamanKerja">
            + Tambahkan
        </button>
    </div>

    {{-- TIMELINE LIST --}}
    <div id="pengalamanList">

        {{-- DEFAULT EMPTY STATE --}}
        <p class="text-muted small">
            Ceritakan pengalaman kerja yang paling relevan dan bisa menarik perhatian HRD
        </p>
        <div class="experience-item d-flex gap-3 mb-4" data-id="1">

    <div class="timeline-dot"></div>

    <div class="flex-grow-1">

        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h6 class="fw-bold mb-1 experience-position">
                    Admin Gudang
                </h6>

                <div class="text-muted small mb-1 experience-company">
                    PT Maju Jaya • Jan 2022 – Des 2023
                </div>
            </div>

            <!-- DROPDOWN -->
            <div class="experience-actions position-relative">
                <button class="btn btn-sm btn-light"
                        onclick="toggleMenu(this)">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>

                <div class="experience-menu shadow">
                    <button onclick="editExperience(this)">
                        <i class="bi bi-pencil me-2"></i>Edit
                    </button>
                    <button onclick="deleteExperience(this)" class="text-danger">
                        <i class="bi bi-trash me-2"></i>Hapus
                    </button>
                </div>
            </div>


        </div>

        <p class="text-muted small mb-0 experience-description">
            Mengelola stok barang dan laporan harian.
        </p>

    </div>
</div>
    </div>

    <hr>
</div>

{{-- ================= PENDIDIKAN ================= --}}
<div class="cv-section mb-5">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold text-uppercase mb-0">Pendidikan</h6>

        <button
            class="btn btn-link text-primary fw-semibold p-0"
            data-bs-toggle="modal"
            data-bs-target="#modalPendidikan">
            + Tambahkan
        </button>
    </div>

    <div id="pendidikanList">

        <p class="text-muted small">
            Tambahkan riwayat pendidikan terakhirmu.
        </p>

        <div class="education-item d-flex justify-content-between mb-3" data-id="1">

    <div>
        <h6 class="fw-bold mb-1 education-school">
            SMK Negeri 1 Jakarta
        </h6>

        <div class="text-muted small education-major">
            Teknik Komputer Jaringan
        </div>

        <div class="text-muted small education-period">
            2019 – 2022
        </div>
    </div>

    <div class="education-actions position-relative">
        <button class="btn btn-sm btn-light"
                onclick="toggleEducationMenu(this)">
            <i class="bi bi-three-dots-vertical"></i>
        </button>

        <div class="education-menu shadow">
            <button onclick="editEducation(this)">
                <i class="bi bi-pencil me-2"></i>Edit
            </button>
            <button class="text-danger"
                    onclick="deleteEducation(this)">
                <i class="bi bi-trash me-2"></i>Hapus
            </button>
        </div>
    </div>
        </div>
    </div>
</div>

{{-- ================= SKILLS ================= --}}
<div class="cv-section mb-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold text-uppercase mb-0">Skills</h6>

        <button class="btn btn-link text-primary fw-semibold p-0"
                data-bs-toggle="modal"
                data-bs-target="#modalSkills">
            + Tambahkan
        </button>
    </div>

    <div id="skillsList" class="skills-wrapper">
        <span class="skill-chip readonly">
            Belum ada skill
        </span>
    </div>

    <hr>
</div>

{{-- ================= RESUME ================= --}}
<div class="cv-section mb-5">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold text-uppercase mb-0">Resume</h6>

        <button class="btn btn-link text-primary fw-semibold p-0"
                data-bs-toggle="modal"
                data-bs-target="#modalResume">
            + Tambahkan
        </button>
    </div>

    <p class="text-muted small mb-2">
        Sebanyak 77,4% perusahaan menilai resume sebagai komponen krusial.
    </p>

    {{-- OUTPUT FILE --}}
    <div id="resumeOutput" class="small text-muted">
        Belum ada resume diunggah
    </div>

    <hr>
</div>

{{-- ================= PENGHARGAAN ================= --}}
<div class="cv-section mb-5">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold text-uppercase mb-0">Penghargaan</h6>

        <button class="btn btn-link text-primary fw-semibold p-0"
                data-bs-toggle="modal"
                data-bs-target="#modalPenghargaan">
            + Tambahkan
        </button>
    </div>

    <div id="penghargaanList">
        <p class="text-muted small">
            Beritahu prestasimu dengan menambahkan penghargaan di sini.
        </p>
    </div>

    <hr>
</div>

{{-- ================= SERTIFIKAT ================= --}}
<div class="cv-section mb-5">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold text-uppercase mb-0">Sertifikat</h6>

        <button class="btn btn-link text-primary fw-semibold p-0"
                data-bs-toggle="modal"
                data-bs-target="#modalSertifikat">
            + Tambahkan
        </button>
    </div>

    {{-- LIST SERTIFIKAT --}}
    <div id="sertifikatList">
        <p class="text-muted small">
            Beritahu prestasimu dengan menambahkan sertifikat di sini.
        </p>
    </div>

    <hr>
</div>

{{-- ================= PENGALAMAN ORGANISASI & RELAWAN ================= --}}
<div class="cv-section mb-5">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold text-uppercase mb-0">
            Pengalaman Organisasi & Relawan
        </h6>

        <button class="btn btn-link text-primary fw-semibold p-0"
                data-bs-toggle="modal"
                data-bs-target="#modalOrganisasi">
            + Tambahkan
        </button>
    </div>

    <div id="organisasiList">
        <p class="text-muted small">
            Adakah kegiatan ekstrakurikuler atau relawan yang ingin kamu tampilkan?
        </p>
    </div>

    <hr>
</div>

</div>
</div>

{{-- ========================= MODAL DATA DIRI ============================ --}}

<div class="modal fade" id="modalDataDiri" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 rounded-4">

            <form>

                {{-- ================= HEADER ================= --}}
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Data Diri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                {{-- ================= BODY ================= --}}
                <div class="modal-body px-4">

                    {{-- FOTO --}}
                    <label for="avatar" class="text-center d-block mb-4" style="cursor:pointer">

                        <div class="mx-auto rounded-circle bg-light d-flex align-items-center justify-content-center"
                             style="width:96px;height:96px">

                            <img id="avatarPreview" class="w-100 h-100 rounded-circle d-none">
                            <i id="avatarIcon" class="bi bi-person fs-1 text-secondary"></i>

                        </div>

                        <small class="text-muted">Klik untuk ubah foto</small>

                    </label>

                    <input type="file"
                           id="avatar"
                           class="d-none"
                           accept="image/*"
                           onchange="previewAvatar(event)">

                    {{-- NAMA --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Depan</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Belakang</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    {{-- WHATSAPP --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nomor WhatsApp</label>
                        <input type="text" class="form-control">
                        <small class="text-success">
                            <i class="bi bi-whatsapp"></i> Pastikan nomor WhatsApp aktif
                        </small>
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" disabled value="mutianandhika@gmail.com">
                        <small class="text-muted">Email telah diverifikasi</small>
                    </div>

                </div>

                {{-- ================= FOOTER ================= --}}
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">Simpan</button>
                </div>

            </form>

        </div>

    </div>

</div>

{{-- ========================= MODAL TENTANG SAYA ========================= --}}
<div class="modal fade" id="modalTentangSaya" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            {{-- HEADER --}}
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Tentang Saya</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body px-4">

                <p class="text-muted small mb-2">
                    Beritahu tentang dirimu sehingga perusahaan lebih mudah memahami potensimu.
                </p>

                <textarea
                    id="tentangSayaInput"
                    class="form-control"
                    rows="5"
                    maxlength="2600"
                    placeholder="Ceritakan tentang dirimu..."
                    oninput="updateCounter()"></textarea>

                <div class="d-flex justify-content-end mt-1">
                    <small class="text-muted">
                        <span id="charCount">0</span> / 2600
                    </small>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0">

                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Batal
                </button>

                <button type="button"
                        class="btn btn-primary px-4"
                        onclick="saveTentangSaya()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>

            </div>

        </div>

    </div>

</div>

{{-- ================= MODAL PENGALAMAN KERJA ================= --}}
<div class="modal fade" id="modalPengalamanKerja" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 rounded-4 shadow">

            {{-- HEADER --}}
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Tambah Pengalaman Kerja</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            

            <div class="modal-body px-4">
<input type="hidden" id="experienceEditId">
                {{-- POSISI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Posisi / Jabatan</label>
                    <input type="text"
                           class="form-control"
                           id="expPosition"
                           placeholder="Contoh: Admin Gudang">
                </div>

                {{-- PERUSAHAAN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Perusahaan</label>
                    <input type="text"
                           class="form-control"
                           id="expCompany"
                           placeholder="Contoh: PT Maju Jaya">
                </div>

                {{-- PERIODE --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Mulai</label>
                        <input type="month" class="form-control" id="expStart">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Selesai</label>
                        <input type="month" class="form-control" id="expEnd">
                        <small class="text-muted">Kosongkan jika masih bekerja</small>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi Pekerjaan</label>
                    <textarea class="form-control"
                              rows="4"
                              id="expDescription"
                              placeholder="Jelaskan tanggung jawab dan pencapaianmu"></textarea>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0">

                <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <button type="button"
                        class="btn btn-primary px-4"
                        onclick="addExperience()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>

            </div>

        </div>

    </div>

</div>

{{-- ================= MODAL PENDIDIKAN ================= --}}
<div class="modal fade" id="modalPendidikan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">

            {{-- HEADER --}}
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Tambah Pendidikan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body px-4">
                <input type="hidden" id="educationEditId">

                {{-- INFO --}}
                <div class="alert alert-light small">
                    Harap diperhatikan: Daftar sekolah/perguruan tinggi
                    yang disediakan hanya yang berlaku di Indonesia.
                </div>

                {{-- TINGKAT PENDIDIKAN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Tingkat Pendidikan <span class="text-danger">*</span>
                    </label>
                    <select class="form-select">
                        <option value="">Pilih tingkat pendidikan</option>
                        <option>SMA / SMK</option>
                        <option>D3</option>
                        <option>S1</option>
                        <option>S2</option>
                        <option>S3</option>
                    </select>
                </div>

                {{-- NAMA SEKOLAH --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Sekolah / Perguruan Tinggi <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                        id="eduSchool"
                        class="form-control"
                        placeholder="Contoh: Universitas Indonesia">
                </div>

                {{-- BIDANG STUDI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Bidang Studi <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                        id="eduMajor"
                        class="form-control"
                        placeholder="Contoh: Teknik Informatika">
                </div>

                {{-- DIMULAI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Dimulai <span class="text-danger">*</span>
                    </label>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <select id="eduStart" class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-6">
                            <select id="eduEnd" class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                {{-- BERAKHIR --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Berakhir <span class="text-danger">*</span>
                    </label>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <select class="form-select">
                                <option value="">Bulan</option>
                                <option>Januari</option>
                                <option>Februari</option>
                                <option>Maret</option>
                                <option>April</option>
                                <option>Mei</option>
                                <option>Juni</option>
                                <option>Juli</option>
                                <option>Agustus</option>
                                <option>September</option>
                                <option>Oktober</option>
                                <option>November</option>
                                <option>Desember</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <select class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                {{-- INFORMASI TAMBAHAN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Informasi Tambahan (Opsional)
                    </label>
                    <textarea class="form-control"
                              rows="4"
                              maxlength="2000"
                              placeholder="Contoh: Lulus dengan predikat cumlaude"></textarea>
                    <div class="text-end small text-muted">
                        0 / 2000
                    </div>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0">
                <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <button type="button"
                        class="btn btn-primary px-4"
                        onclick="addEducation()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ================= MODAL SKILLS ================= --}}
<div class="modal fade" id="modalSkills" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Skills</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <p class="text-muted small">
                    Pilih 3–10 skill terkuat kamu
                </p>

                <input id="skillInput"
                       class="form-control mb-3"
                       placeholder="Ketik skill lalu tekan Enter">

                <div id="skillPreview"
                     class="d-flex flex-wrap gap-2"></div>
            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <button class="btn btn-primary"
                        onclick="saveSkills()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ================= MODAL RESUME ================= --}}
<div class="modal fade" id="modalResume" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Resume</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="file"
                       id="resumeInput"
                       class="form-control mb-3"
                       accept="application/pdf">

                {{-- PREVIEW PDF --}}
                <div id="resumePreview"
                     class="border rounded"
                     style="height:400px; display:none;">
                    <iframe id="resumeFrame"
                            style="width:100%; height:100%; border:0;"></iframe>
                </div>

                <small class="text-muted">
                    Format PDF • Maksimal 5 MB
                </small>

            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <button class="btn btn-primary"
                        onclick="saveResume()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ================= MODAL PENGHARGAAN ================= --}}
<div class="modal fade" id="modalPenghargaan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Tambah Penghargaan</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="awardEditId">

                <div class="mb-3">
                    <label class="form-label">Judul Penghargaan *</label>
                    <input type="text"
                           id="awardTitle"
                           class="form-control"
                           placeholder="Contoh: Juara 1 Lomba Desain">
                </div>

                <div class="mb-3">
                    <label class="form-label">Prestasi / Kontribusi *</label>
                    <input type="text"
                           id="awardRole"
                           class="form-control"
                           placeholder="Contoh: Desainer Utama">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun *</label>
                    <select id="awardYear" class="form-select">
                        <option value="">Pilih tahun</option>
                        @for ($year = date('Y'); $year >= 1980; $year--)
                            <option>{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Informasi Tambahan (Opsional)</label>
                    <textarea id="awardDesc"
                              class="form-control"
                              rows="3"
                              maxlength="2000"></textarea>
                </div>

            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <button class="btn btn-primary"
                        onclick="saveAward()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ================= MODAL SERTIFIKAT ================= --}}
<div class="modal fade" id="modalSertifikat" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            {{-- HEADER --}}
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Tambah Sertifikat</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">

                {{-- EDIT ID --}}
                <input type="hidden" id="certificateEditId">

                {{-- NAMA SERTIFIKAT --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Sertifikat <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="certName"
                           class="form-control"
                           placeholder="Contoh: Sertifikat UI/UX Design">
                </div>

                {{-- ORGANISASI PENERBIT --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Organisasi Penerbit <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="certIssuer"
                           class="form-control"
                           placeholder="Contoh: Google, Dicoding">
                </div>

                {{-- TANGGAL TERBIT --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Tanggal Diterbitkan <span class="text-danger">*</span>
                    </label>

                    <div class="row g-2">
                        <div class="col-6">
                            <select id="certIssueMonth" class="form-select">
                                <option value="">Bulan</option>
                                <option>Januari</option>
                                <option>Februari</option>
                                <option>Maret</option>
                                <option>April</option>
                                <option>Mei</option>
                                <option>Juni</option>
                                <option>Juli</option>
                                <option>Agustus</option>
                                <option>September</option>
                                <option>Oktober</option>
                                <option>November</option>
                                <option>Desember</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <select id="certIssueYear" class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                {{-- MASA AKTIF --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Batas Masa Aktif
                    </label>

                    <div class="row g-2">
                        <div class="col-6">
                            <select id="certExpireMonth" class="form-select">
                                <option value="">Bulan</option>
                                <option>Januari</option>
                                <option>Februari</option>
                                <option>Maret</option>
                                <option>April</option>
                                <option>Mei</option>
                                <option>Juni</option>
                                <option>Juli</option>
                                <option>Agustus</option>
                                <option>September</option>
                                <option>Oktober</option>
                                <option>November</option>
                                <option>Desember</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <select id="certExpireYear" class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-check mt-2">
                        <input class="form-check-input"
                               type="checkbox"
                               id="certNoExpire">
                        <label class="form-check-label">
                            Sertifikat ini tidak memiliki batas masa aktif
                        </label>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Informasi Tambahan (Opsional)
                    </label>
                    <textarea id="certDesc"
                              class="form-control"
                              rows="3"
                              maxlength="2000"
                              placeholder="Contoh: Sertifikat tingkat lanjutan"></textarea>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0">
                <button class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <button class="btn btn-primary"
                        onclick="saveCertificate()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ================= MODAL ORGANISASI & RELAWAN ================= --}}
<div class="modal fade" id="modalOrganisasi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            {{-- HEADER --}}
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">
                    Tambah Pengalaman Organisasi & Relawan
                </h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">

                <input type="hidden" id="orgEditId">

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Organisasi atau Kegiatan <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="orgName"
                           class="form-control"
                           placeholder="Contoh: Himpunan Mahasiswa Informatika">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Posisi <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="orgRole"
                           class="form-control"
                           placeholder="Contoh: Ketua Divisi Acara">
                </div>

                {{-- MULAI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Mulai</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <select id="orgStartMonth" class="form-select">
                                <option value="">Bulan</option>
                                <option>Januari</option>
                                <option>Februari</option>
                                <option>Maret</option>
                                <option>April</option>
                                <option>Mei</option>
                                <option>Juni</option>
                                <option>Juli</option>
                                <option>Agustus</option>
                                <option>September</option>
                                <option>Oktober</option>
                                <option>November</option>
                                <option>Desember</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <select id="orgStartYear" class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                {{-- SELESAI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Selesai</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <select id="orgEndMonth" class="form-select">
                                <option value="">Bulan</option>
                                <option>Januari</option>
                                <option>Februari</option>
                                <option>Maret</option>
                                <option>April</option>
                                <option>Mei</option>
                                <option>Juni</option>
                                <option>Juli</option>
                                <option>Agustus</option>
                                <option>September</option>
                                <option>Oktober</option>
                                <option>November</option>
                                <option>Desember</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <select id="orgEndYear" class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-check mt-2">
                        <input class="form-check-input"
                               type="checkbox"
                               id="orgOngoing">
                        <label class="form-check-label">
                            Saya masih menjadi sukarelawan di sini
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Informasi tambahan (Opsional)
                    </label>
                    <textarea id="orgDesc"
                              class="form-control"
                              rows="3"
                              maxlength="2000"></textarea>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0">
                <button class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>
                <button class="btn btn-primary"
                        onclick="saveOrg()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>

@endsection

{{-- ============================ SCRIPTS ================================= --}}

@push('scripts')
<script>
    let experienceCounter = 2;
    let educationCounter  = 2;

function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();

    reader.onload = function(e) {
        document.getElementById('avatarPreview').src = e.target.result;
        document.getElementById('avatarPreview').classList.remove('d-none');
        document.getElementById('avatarIcon').classList.add('d-none');
    };

    reader.readAsDataURL(file);
}

function updateCounter() {
    const textarea = document.getElementById('tentangSayaInput');
    document.getElementById('charCount').innerText = textarea.value.length;
}

function saveTentangSaya() {
    const value = document.getElementById('tentangSayaInput').value;
    document.getElementById('tentangSayaOutput').innerText =
        value || 'Belum ada deskripsi.';
}

/* ================= ADD / UPDATE ================= */
function addExperience() {

    const editId   = document.getElementById('experienceEditId').value;
    const position = document.getElementById('expPosition').value;
    const company  = document.getElementById('expCompany').value;
    const start    = document.getElementById('expStart').value;
    const end      = document.getElementById('expEnd').value || 'Sekarang';
    const desc     = document.getElementById('expDescription').value;

    if (!position || !company || !start) {
        alert('Posisi, perusahaan, dan tanggal mulai wajib diisi.');
        return;
    }

    const list = document.getElementById('pengalamanList');

    // ================= UPDATE =================
    if (editId) {
        const item = document.querySelector(`[data-id="${editId}"]`);

        item.querySelector('.experience-position').innerText = position;
        item.querySelector('.experience-company').innerText =
            `${company} • ${start} – ${end}`;
        item.querySelector('.experience-description').innerText = desc;

        resetExperienceForm();
        return;
    }

    // ================= ADD BARU =================
    const html = `
        <div class="experience-item d-flex gap-3 mb-4" data-id="${experienceCounter}">
            <div class="timeline-dot"></div>

            <div class="flex-grow-1">

                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="fw-bold mb-1 experience-position">${position}</h6>
                        <div class="text-muted small mb-1 experience-company">
                            ${company} • ${start} – ${end}
                        </div>
                    </div>

                    <div class="experience-actions position-relative">
                        <button class="btn btn-sm btn-light"
                                onclick="toggleMenu(this)">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>

                        <div class="experience-menu shadow">
                            <button onclick="editExperience(this)">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </button>
                            <button class="text-danger"
                                    onclick="deleteExperience(this)">
                                <i class="bi bi-trash me-2"></i>Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <p class="text-muted small mb-0 experience-description">
                    ${desc}
                </p>

            </div>
        </div>
    `;

    if (list.querySelector('p')) {
        list.innerHTML = '';
    }

    list.insertAdjacentHTML('beforeend', html);
    experienceCounter++;

    resetExperienceForm();
}

/* ================= EDIT ================= */
function editExperience(button) {
    button.closest('.experience-menu').style.display = 'none';
    const item = button.closest('.experience-item');

    const position = item.querySelector('.experience-position').innerText;
    const company  = item.querySelector('.experience-company').innerText;
    const desc     = item.querySelector('.experience-description').innerText;

    document.getElementById('experienceEditId').value =
        item.dataset.id;
    document.getElementById('expPosition').value = position;
    document.getElementById('expCompany').value  = company.split(' • ')[0];
    document.getElementById('expDescription').value = desc;

    new bootstrap.Modal(
        document.getElementById('modalPengalamanKerja')
    ).show();
}

function deleteExperience(button) {
    if (!confirm('Yakin hapus pengalaman ini?')) return;
    button.closest('.experience-menu').style.display = 'none';
    button.closest('.experience-item').remove();
}

/* ================= RESET ================= */
function resetExperienceForm() {
    document.getElementById('experienceEditId').value = '';
    document.getElementById('expPosition').value = '';
    document.getElementById('expCompany').value = '';
    document.getElementById('expStart').value = '';
    document.getElementById('expEnd').value = '';
    document.getElementById('expDescription').value = '';
}
function toggleMenu(button) {
    const menu = button.nextElementSibling;

    // tutup semua menu lain
    document.querySelectorAll('.experience-menu').forEach(el => {
        if (el !== menu) el.style.display = 'none';
    });

    menu.style.display =
        menu.style.display === 'block' ? 'none' : 'block';
}

// klik di luar → tutup menu
document.addEventListener('click', function (e) {
    if (!e.target.closest('.experience-actions')) {
        document.querySelectorAll('.experience-menu').forEach(el => {
            el.style.display = 'none';
        });
    }
});

function toggleEducationMenu(button) {
    const menu = button.nextElementSibling;

    document.querySelectorAll('.education-menu').forEach(el => {
        if (el !== menu) el.style.display = 'none';
    });

    menu.style.display =
        menu.style.display === 'block' ? 'none' : 'block';
}
document.addEventListener('click', function (e) {
    if (!e.target.closest('.education-actions')) {
        document.querySelectorAll('.education-menu').forEach(el => {
            el.style.display = 'none';
        });
    }
});

function addEducation() {

    const editId = document.getElementById('educationEditId').value;
    const school = document.getElementById('eduSchool').value;
    const major  = document.getElementById('eduMajor').value;
    const start  = document.getElementById('eduStart').value;
    const end    = document.getElementById('eduEnd').value;

    if (!school || !major || !start || !end) {
        alert('Lengkapi data pendidikan.');
        return;
    }

    const list = document.getElementById('pendidikanList');

    // ===== UPDATE =====
    if (editId) {
        const item = document.querySelector(`[data-id="${editId}"]`);

        item.querySelector('.education-school').innerText = school;
        item.querySelector('.education-major').innerText  = major;
        item.querySelector('.education-period').innerText =
            `${start} – ${end}`;

        resetEducationForm();
        return;
    }

    // ===== ADD BARU =====
    const html = `
        <div class="education-item d-flex justify-content-between mb-3"
             data-id="${educationCounter}">
            <div>
                <h6 class="fw-bold mb-1 education-school">${school}</h6>
                <div class="text-muted small education-major">${major}</div>
                <div class="text-muted small education-period">
                    ${start} – ${end}
                </div>
            </div>

            <div class="education-actions position-relative">
                <button class="btn btn-sm btn-light"
                        onclick="toggleEducationMenu(this)">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>

                <div class="education-menu shadow">
                    <button onclick="editEducation(this)">
                        <i class="bi bi-pencil me-2"></i>Edit
                    </button>
                    <button class="text-danger"
                            onclick="deleteEducation(this)">
                        <i class="bi bi-trash me-2"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    `;

    if (list.querySelector('p')) {
        list.innerHTML = '';
    }

    list.insertAdjacentHTML('beforeend', html);
    educationCounter++;

    resetEducationForm();
}
function editEducation(button) {
    const item = button.closest('.education-item');

    document.getElementById('educationEditId').value =
        item.dataset.id;

    document.getElementById('eduSchool').value =
        item.querySelector('.education-school').innerText;

    document.getElementById('eduMajor').value =
        item.querySelector('.education-major').innerText;

    const period = item
        .querySelector('.education-period')
        .innerText.split(' – ');

    document.getElementById('eduStart').value = period[0];
    document.getElementById('eduEnd').value   = period[1];

    new bootstrap.Modal(
        document.getElementById('modalPendidikan')
    ).show();

    button.closest('.education-menu').style.display = 'none';
}

function deleteEducation(button) {
    if (!confirm('Yakin hapus pendidikan ini?')) return;

    button.closest('.education-item').remove();
}
function resetEducationForm() {
    document.getElementById('educationEditId').value = '';
    document.getElementById('eduSchool').value = '';
    document.getElementById('eduMajor').value = '';
    document.getElementById('eduStart').value = '';
    document.getElementById('eduEnd').value = '';
}

/* =========================================================
   SKILLS (FINAL & BENAR)
========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    const skillInput   = document.getElementById('skillInput');
    const skillPreview = document.getElementById('skillPreview');
    const skillsList   = document.getElementById('skillsList');

    let skills = [];

    /* ================= TAMBAH SKILL ================= */
    function addSkill(value) {
        value = value.trim();

        if (!value) return;
        if (skills.includes(value)) return;
        if (skills.length >= 10) {
            alert('Maksimal 10 skill');
            return;
        }

        skills.push(value);
        renderPreview();
    }

    /* ================= ENTER ================= */
    skillInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addSkill(this.value);
            this.value = '';
        }
    });

    /* ================= RENDER CHIP DI MODAL ================= */
    function renderPreview() {
        skillPreview.innerHTML = '';

        skills.forEach((skill, index) => {
            skillPreview.innerHTML += `
                <span class="skill-chip">
                    ${skill}
                    <button type="button" onclick="removeSkill(${index})">&times;</button>
                </span>
            `;
        });
    }

    /* ================= HAPUS ================= */
    window.removeSkill = function (index) {
        skills.splice(index, 1);
        renderPreview();
    }

    /* ================= SIMPAN ================= */
    window.saveSkills = function () {

        // 👉 JIKA USER KETIK TAPI BELUM ENTER
        if (skillInput.value.trim()) {
            addSkill(skillInput.value);
            skillInput.value = '';
        }

        skillsList.innerHTML = '';

        if (!skills.length) {
            skillsList.innerHTML = `
                <span class="skill-chip readonly">Belum ada skill</span>
            `;
            return;
        }

        skills.forEach(skill => {
            skillsList.innerHTML += `
                <span class="skill-chip readonly">${skill}</span>
            `;
        });
    };

    /* ================= BUKA MODAL ================= */
    const modalSkills = document.getElementById('modalSkills');
    modalSkills.addEventListener('show.bs.modal', renderPreview);

});

/* =========================================================
   RESUME
========================================================= */

let resumeFile = null;

/* ================= PILIH FILE → PREVIEW ================= */
document.addEventListener('DOMContentLoaded', function () {
    const resumeInput = document.getElementById('resumeInput');
    if (!resumeInput) return;

    resumeInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (file.type !== 'application/pdf') {
            alert('Resume harus berupa PDF');
            this.value = '';
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran maksimal 5 MB');
            this.value = '';
            return;
        }

        const url = URL.createObjectURL(file);
        document.getElementById('resumePreview').style.display = 'block';
        document.getElementById('resumeFrame').src = url;
    });
});


/* ================= SIMPAN RESUME ================= */
function saveResume() {
    const input = document.getElementById('resumeInput');

    if (!input.files.length) {
        alert('Pilih file PDF terlebih dahulu');
        return;
    }

    resumeFile = input.files[0];
    renderResume();

    input.value = '';
}

/* ================= TAMPILKAN DI PROFILE ================= */
function renderResume() {
    const output = document.getElementById('resumeOutput');

    if (!resumeFile) {
        output.innerHTML = 'Belum ada resume diunggah';
        output.classList.add('text-muted');
        return;
    }

    output.classList.remove('text-muted');

    output.innerHTML = `
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-primary">
                <i class="bi bi-file-earmark-pdf me-1"></i>
                ${resumeFile.name}
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-light"
                        data-bs-toggle="modal"
                        data-bs-target="#modalResume">
                    <i class="bi bi-pencil"></i>
                </button>

                <button class="btn btn-sm btn-light text-danger"
                        onclick="deleteResume()">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;
}

/* ================= HAPUS ================= */
function deleteResume() {
    if (!confirm('Yakin ingin menghapus resume?')) return;

    resumeFile = null;
    document.getElementById('resumePreview').style.display = 'none';
    document.getElementById('resumeFrame').src = '';
    renderResume();
}

/* ================= PENGHARGAAN ================= */

let awards = [];
let awardCounter = 1;

/* ================= SIMPAN / UPDATE ================= */
function saveAward() {

    const editId = document.getElementById('awardEditId').value;
    const title  = document.getElementById('awardTitle').value.trim();
    const role   = document.getElementById('awardRole').value.trim();
    const year   = document.getElementById('awardYear').value;
    const desc   = document.getElementById('awardDesc').value.trim();

    if (!title || !role || !year) {
        alert('Lengkapi data wajib');
        return;
    }

    if (editId) {
        const item = awards.find(a => a.id == editId);
        item.title = title;
        item.role  = role;
        item.year  = year;
        item.desc  = desc;
    } else {
        awards.push({
            id: awardCounter++,
            title, role, year, desc
        });
    }

    resetAwardForm();
    renderAwards();
}

/* ================= RENDER LIST ================= */
function renderAwards() {

    const list = document.getElementById('penghargaanList');
    list.innerHTML = '';

    if (!awards.length) {
        list.innerHTML = `
            <p class="text-muted small">
                Beritahu prestasimu dengan menambahkan penghargaan di sini.
            </p>`;
        return;
    }

    awards.forEach(item => {
        list.innerHTML += `
            <div class="award-item d-flex justify-content-between align-items-start mb-3">
                <div>
                    <div class="fw-semibold">${item.title}</div>
                    <div class="text-muted small">
                        ${item.role} • ${item.year}
                    </div>
                    ${item.desc
                        ? `<div class="text-muted small mt-1">${item.desc}</div>`
                        : ''
                    }
                </div>

                <div class="award-actions position-relative">
                    <button class="btn btn-sm btn-light"
                            onclick="toggleAwardMenu(this)">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>

                    <div class="award-menu shadow">
                        <button onclick="editAward(${item.id})">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </button>
                        <button class="text-danger"
                                onclick="deleteAward(${item.id})">
                            <i class="bi bi-trash me-2"></i>Hapus
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
}

/* ================= EDIT ================= */
function editAward(id) {

    const item = awards.find(a => a.id === id);

    document.getElementById('awardEditId').value = item.id;
    document.getElementById('awardTitle').value  = item.title;
    document.getElementById('awardRole').value   = item.role;
    document.getElementById('awardYear').value   = item.year;
    document.getElementById('awardDesc').value   = item.desc;

    new bootstrap.Modal(
        document.getElementById('modalPenghargaan')
    ).show();
}

/* ================= HAPUS ================= */
function deleteAward(id) {
    if (!confirm('Yakin hapus penghargaan ini?')) return;

    awards = awards.filter(a => a.id !== id);
    renderAwards();
}

/* ================= RESET FORM ================= */
function resetAwardForm() {
    document.getElementById('awardEditId').value = '';
    document.getElementById('awardTitle').value  = '';
    document.getElementById('awardRole').value   = '';
    document.getElementById('awardYear').value   = '';
    document.getElementById('awardDesc').value   = '';
}

function toggleAwardMenu(button) {
    const menu = button.nextElementSibling;

    document.querySelectorAll('.award-menu').forEach(el => {
        if (el !== menu) el.style.display = 'none';
    });

    menu.style.display =
        menu.style.display === 'block' ? 'none' : 'block';
}

// klik di luar → tutup menu
document.addEventListener('click', function (e) {
    if (!e.target.closest('.award-actions')) {
        document.querySelectorAll('.award-menu').forEach(el => {
            el.style.display = 'none';
        });
    }
});

/* =========================
   SERTIFIKAT
========================= */

let certificates = [];
let certificateCounter = 1;

/* ========== SIMPAN / UPDATE ========== */
function saveCertificate() {

    const editId   = document.getElementById('certificateEditId').value;
    const name     = document.getElementById('certName').value.trim();
    const issuer   = document.getElementById('certIssuer').value.trim();
    const issueM   = document.getElementById('certIssueMonth').value;
    const issueY   = document.getElementById('certIssueYear').value;
    const expireM  = document.getElementById('certExpireMonth').value;
    const expireY  = document.getElementById('certExpireYear').value;
    const noExpire = document.getElementById('certNoExpire').checked;
    const desc     = document.getElementById('certDesc').value.trim();

    if (!name || !issuer || !issueM || !issueY) {
        alert('Lengkapi data wajib');
        return;
    }

    const period = noExpire
        ? `${issueM} ${issueY} • Tidak kedaluwarsa`
        : `${issueM} ${issueY} – ${expireM} ${expireY}`;

    if (editId) {
        const item = certificates.find(c => c.id == editId);
        item.name = name;
        item.issuer = issuer;
        item.period = period;
        item.desc = desc;
    } else {
        certificates.push({
            id: certificateCounter++,
            name,
            issuer,
            period,
            desc
        });
    }

    resetCertificateForm();
    renderCertificates();
}

/* ========== RENDER LIST ========== */
function renderCertificates() {

    const list = document.getElementById('sertifikatList');
    list.innerHTML = '';

    if (!certificates.length) {
        list.innerHTML = `
            <p class="text-muted small">
                Beritahu prestasimu dengan menambahkan sertifikat di sini.
            </p>`;
        return;
    }

    certificates.forEach(item => {
        list.innerHTML += `
            <div class="certificate-item d-flex justify-content-between mb-3">
                <div>
                    <div class="fw-semibold">${item.name}</div>
                    <div class="text-muted small">
                        ${item.issuer} • ${item.period}
                    </div>
                    ${item.desc
                        ? `<div class="text-muted small mt-1">${item.desc}</div>`
                        : ''
                    }
                </div>

                <div class="certificate-actions position-relative">
                    <button class="btn btn-sm btn-light"
                            onclick="toggleCertificateMenu(this)">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>

                    <div class="certificate-menu shadow">
                        <button onclick="editCertificate(${item.id})">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </button>
                        <button class="text-danger"
                                onclick="deleteCertificate(${item.id})">
                            <i class="bi bi-trash me-2"></i>Hapus
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
}

/* ========== TOGGLE MENU ========== */
function toggleCertificateMenu(button) {

    const menu = button.nextElementSibling;

    document.querySelectorAll('.certificate-menu').forEach(el => {
        if (el !== menu) el.style.display = 'none';
    });

    menu.style.display =
        menu.style.display === 'block' ? 'none' : 'block';
}

document.addEventListener('click', function (e) {
    if (!e.target.closest('.certificate-actions')) {
        document.querySelectorAll('.certificate-menu').forEach(el => {
            el.style.display = 'none';
        });
    }
});

/* ========== EDIT ========== */
function editCertificate(id) {

    const item = certificates.find(c => c.id === id);

    document.getElementById('certificateEditId').value = item.id;
    document.getElementById('certName').value = item.name;
    document.getElementById('certIssuer').value = item.issuer;
    document.getElementById('certDesc').value = item.desc;

    new bootstrap.Modal(
        document.getElementById('modalSertifikat')
    ).show();
}

/* ========== HAPUS ========== */
function deleteCertificate(id) {
    if (!confirm('Yakin hapus sertifikat ini?')) return;

    certificates = certificates.filter(c => c.id !== id);
    renderCertificates();
}

/* ========== RESET FORM ========== */
function resetCertificateForm() {
    document.getElementById('certificateEditId').value = '';
    document.getElementById('certName').value = '';
    document.getElementById('certIssuer').value = '';
    document.getElementById('certIssueMonth').value = '';
    document.getElementById('certIssueYear').value = '';
    document.getElementById('certExpireMonth').value = '';
    document.getElementById('certExpireYear').value = '';
    document.getElementById('certNoExpire').checked = false;
    document.getElementById('certDesc').value = '';
}

/* =========================================================
   ORGANISASI & RELAWAN
========================================================= */

let orgs = [];
let orgCounter = 1;

/* ================= SIMPAN / UPDATE ================= */
function saveOrg() {

    const editId = document.getElementById('orgEditId').value;
    const name   = document.getElementById('orgName').value.trim();
    const role   = document.getElementById('orgRole').value.trim();

    const sm = document.getElementById('orgStartMonth').value;
    const sy = document.getElementById('orgStartYear').value;
    const em = document.getElementById('orgEndMonth').value;
    const ey = document.getElementById('orgEndYear').value;

    const ongoing = document.getElementById('orgOngoing').checked;
    const desc    = document.getElementById('orgDesc').value.trim();

    if (!name || !role || !sm || !sy) {
        alert('Lengkapi data wajib');
        return;
    }

    let period = `${sm} ${sy} – `;
    period += ongoing ? 'Sekarang' : `${em} ${ey}`;

    if (editId) {
        const item = orgs.find(o => o.id == editId);
        item.name   = name;
        item.role   = role;
        item.period = period;
        item.desc   = desc;
    } else {
        orgs.push({
            id: orgCounter++,
            name,
            role,
            period,
            desc
        });
    }

    resetOrgForm();
    renderOrgs();
}

/* ================= RENDER LIST ================= */
function renderOrgs() {

    const list = document.getElementById('organisasiList');
    list.innerHTML = '';

    if (!orgs.length) {
        list.innerHTML = `
            <p class="text-muted small">
                Adakah kegiatan ekstrakurikuler atau relawan yang ingin kamu tampilkan?
            </p>`;
        return;
    }

    orgs.forEach(item => {
        list.innerHTML += `
            <div class="org-item d-flex justify-content-between mb-3">

                <div>
                    <div class="fw-semibold">${item.name}</div>
                    <div class="text-muted small">
                        ${item.role} • ${item.period}
                    </div>
                    ${item.desc
                        ? `<div class="text-muted small mt-1">${item.desc}</div>`
                        : ''
                    }
                </div>

                <div class="org-actions position-relative">
                    <button class="btn btn-sm btn-light"
                            onclick="toggleOrgMenu(this)">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>

                    <div class="org-menu shadow">
                        <button onclick="editOrg(${item.id})">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </button>
                        <button class="text-danger"
                                onclick="deleteOrg(${item.id})">
                            <i class="bi bi-trash me-2"></i>Hapus
                        </button>
                    </div>
                </div>

            </div>
        `;
    });
}

/* ================= TOGGLE MENU ================= */
function toggleOrgMenu(button) {

    const menu = button.nextElementSibling;

    // tutup menu lain
    document.querySelectorAll('.org-menu').forEach(el => {
        if (el !== menu) el.style.display = 'none';
    });

    menu.style.display =
        menu.style.display === 'block' ? 'none' : 'block';
}

/* ================= KLIK DI LUAR ================= */
document.addEventListener('click', function (e) {
    if (!e.target.closest('.org-actions')) {
        document.querySelectorAll('.org-menu').forEach(el => {
            el.style.display = 'none';
        });
    }
});

/* ================= EDIT ================= */
function editOrg(id) {

    const item = orgs.find(o => o.id === id);

    document.getElementById('orgEditId').value = item.id;
    document.getElementById('orgName').value   = item.name;
    document.getElementById('orgRole').value   = item.role;
    document.getElementById('orgDesc').value   = item.desc;

    const period = item.period.split(' – ');
    const start  = period[0].split(' ');
    document.getElementById('orgStartMonth').value = start[0];
    document.getElementById('orgStartYear').value  = start[1];

    if (period[1] === 'Sekarang') {
        document.getElementById('orgOngoing').checked = true;
    } else {
        const end = period[1].split(' ');
        document.getElementById('orgEndMonth').value = end[0];
        document.getElementById('orgEndYear').value  = end[1];
        document.getElementById('orgOngoing').checked = false;
    }

    new bootstrap.Modal(
        document.getElementById('modalOrganisasi')
    ).show();
}

/* ================= HAPUS ================= */
function deleteOrg(id) {
    if (!confirm('Yakin hapus pengalaman ini?')) return;

    orgs = orgs.filter(o => o.id !== id);
    renderOrgs();
}

/* ================= RESET FORM ================= */
function resetOrgForm() {
    document.getElementById('orgEditId').value = '';
    document.getElementById('orgName').value = '';
    document.getElementById('orgRole').value = '';
    document.getElementById('orgStartMonth').value = '';
    document.getElementById('orgStartYear').value = '';
    document.getElementById('orgEndMonth').value = '';
    document.getElementById('orgEndYear').value = '';
    document.getElementById('orgOngoing').checked = false;
    document.getElementById('orgDesc').value = '';
}

</script>
@endpush
