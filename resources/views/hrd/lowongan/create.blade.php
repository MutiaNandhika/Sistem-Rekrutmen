@extends('layouts.hrd')

@section('title', 'Tambah Lowongan Kerja')

@section('breadcrumb')
<nav class="breadcrumb-wrapper">
    <a href="{{ route('hrd.dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('lowongan.index') }}">Lowongan</a>
    <span>/</span>
    <span class="active">Tambah Lowongan</span>
</nav>
@endsection

@section('content')

{{-- PAGE TITLE --}}
<h4 class="fw-bold text-center mb-4">Pasang Loker</h4>

{{-- STEP INDICATOR --}}
<div class="d-flex justify-content-center align-items-center gap-3 mb-4">

    <div class="d-flex align-items-center gap-2">
        <span class="step-circle active">1</span>
        <span class="fw-semibold">Info Loker</span>
    </div>

    <div class="step-line"></div>

    <div class="d-flex align-items-center gap-2 text-muted">
        <span class="step-circle">2</span>
        <span>Deskripsi Pekerjaan</span>
    </div>

</div>


<form>

{{-- ================= DETAIL & JENIS PEKERJAAN ================= --}}
<div class="card mb-4">
    <div class="card-header fw-semibold">
        Detail & Jenis Pekerjaan <span class="text-danger">*</span>
    </div>

    <div class="card-body">

        <div class="mb-3">
            <label class="form-label fw-semibold">
                Nama Loker <i class="bi bi-info-circle"></i>
            </label>
            <input type="text"
                   class="form-control"
                   placeholder="Misal: Sales">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">
                Bidang Kerja <i class="bi bi-info-circle"></i>
            </label>
            <select class="form-select">
                <option selected>Belum pilih</option>
                <option>Sales</option>
                <option>Marketing</option>
                <option>IT</option>
                <option>Finance</option>
            </select>
        </div>

        <div class="mb-2">
            <label class="form-label fw-semibold">Tipe Kerja</label>
            <select class="form-select">
                <option>Penuh Waktu</option>
                <option>Paruh Waktu</option>
                <option>Kontrak</option>
            </select>
        </div>

    </div>
</div>

{{-- ================= LOKASI ================= --}}
<div class="card mb-4">
    <div class="card-header fw-semibold">
        Lokasi <span class="text-danger">*</span>
    </div>

    <div class="card-body">

        <label class="form-label fw-semibold">Sistem Kerja</label>
        <div class="d-flex gap-4 mb-3">
            <div>
                <input type="radio" name="sistem_kerja"> Di Kantor
            </div>
            <div>
                <input type="radio" name="sistem_kerja"> Remote/Dari Rumah
            </div>
            <div>
                <input type="radio" name="sistem_kerja"> Hybrid
            </div>
        </div>

        <div>
            <label class="form-label fw-semibold">Lokasi</label>
            <input type="text"
                   class="form-control"
                   placeholder="Pilih Alamat Kantor">
        </div>

    </div>
</div>

{{-- ================= GAJI ================= --}}
<div class="card mb-4">
    <div class="card-header fw-semibold">
        Gaji <span class="text-danger">*</span>
    </div>

    <div class="card-body d-flex align-items-center gap-2">
        <input type="number" class="form-control" placeholder="Min">
        <span>hingga</span>
        <input type="number" class="form-control" placeholder="Max">
    </div>
</div>

{{-- ================= PERSYARATAN KERJA ================= --}}
<div class="card mb-4">
    <div class="card-header fw-semibold">
        Persyaratan Kerja <span class="text-danger">*</span>
    </div>

    <div class="card-body">

        <label class="form-label fw-semibold">Jenis Kelamin</label>
        <div class="d-flex gap-4 mb-3">
            <div><input type="radio" name="jk"> Laki-Laki</div>
            <div><input type="radio" name="jk"> Perempuan</div>
        </div>

        <label class="form-label fw-semibold">Usia</label>
        <div class="d-flex align-items-center gap-2 mb-2">
            <input type="number" class="form-control" placeholder="Min">
            <span>hingga</span>
            <input type="number" class="form-control" placeholder="Max">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox">
            <label class="form-check-label">
                Tidak ada batasan umur
            </label>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">
                Skill Wajib Diisi (Maksimal 20)
            </label>
            <select class="form-select">
                <option>Cari skill</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">
                Pendidikan Minimal yang Dibutuhkan
            </label>
            <select class="form-select">
                <option>Belum pilih</option>
                <option>SMA/SMK</option>
                <option>D3</option>
                <option>S1</option>
            </select>
        </div>

        <div>
            <label class="form-label fw-semibold">
                Pengalaman Kerja yang Dibutuhkan
            </label>
            <select class="form-select">
                <option>Belum pilih</option>
                <option>Fresh Graduate</option>
                <option>1–2 Tahun</option>
                <option>> 3 Tahun</option>
            </select>
        </div>

    </div>
</div>

{{-- ================= ACTION BUTTON ================= --}}
<div class="d-flex justify-content-end gap-2 mb-5">
    <a href="{{ route('lowongan.index') }}" class="btn btn-light border">
        Kembali
    </a>

    <a href="{{ route('lowongan.create.deskripsi') }}"
       class="btn btn-primary">
        Selanjutnya
    </a>
</div>


</form>

@endsection
