@extends('layouts.hrd')

@section('title', 'Tambah Lowongan Kerja')

@section('breadcrumb')
<nav class="breadcrumb-wrapper">
    <a href="{{ route('hrd.dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('hrd.lowongan.index') }}">Lowongan</a>
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


<form
action="{{ isset($lowongan) ? route('hrd.lowongan.update',$lowongan->id) : route('hrd.lowongan.store') }}"
method="POST">
@csrf
@if(isset($lowongan)) @method('PUT') @endif

{{-- ================= DETAIL & JENIS PEKERJAAN ================= --}}
<div class="card mb-4">
    <div class="card-header fw-semibold">
        Detail & Jenis Pekerjaan <span class="text-danger">*</span>
    </div>

    <div class="card-body">

        <div class="mb-3">
            <label class="form-label fw-semibold">
                Nama Loker</i>
            </label>
            <input type="text" name="nama_lowongan" class="form-control"
               value="{{ old('nama_lowongan', $lowongan->nama_lowongan ?? '') }}"
               required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold mt-3">Bidang Kerja</label>
        <select name="bidang_kerja" class="form-select" required>
            @foreach (['Sales','Marketing','IT','Finance'] as $bidang)
                <option value="{{ $bidang }}"
                    {{ old('bidang_kerja',$lowongan->bidang_kerja ?? '') == $bidang ? 'selected' : '' }}>
                    {{ $bidang }}
                </option>
            @endforeach
        </select>
        </div>

        <div class="mb-2">
            <label class="form-label fw-semibold mt-3">Tipe Kerja</label>
            <select name="tipe_kerja" class="form-select" required>
                @foreach (['penuh_waktu'=>'Penuh Waktu','paruh_waktu'=>'Paruh Waktu','kontrak'=>'Kontrak'] as $val=>$label)
                    <option value="{{ $val }}"
                        {{ old('tipe_kerja',$lowongan->tipe_kerja ?? '') == $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
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
            @foreach (['kantor'=>'Di Kantor','remote'=>'Remote','hybrid'=>'Hybrid'] as $val=>$label)
            <div>
                <input type="radio" name="sistem_kerja" value="{{ $val }}"
       {{ old('sistem_kerja',$lowongan->sistem_kerja ?? '') == $val ? 'checked' : '' }}
       required>
                {{ $label }}
            </div>
        @endforeach
        </div>

        <div>
            <label class="form-label fw-semibold mt-3">Lokasi</label>
            <input type="text" name="lokasi" class="form-control"
               value="{{ old('lokasi',$lowongan->lokasi ?? '') }}" required>
        </div>
        <div>
            <label class="form-label fw-semibold mt-3">Penempatan Kerja</label>
            <input type="text"
           name="penempatan"
           class="form-control"
           placeholder="Contoh: Perusahaan Klien (Manufaktur)"
           value="{{ old('penempatan', $lowongan->penempatan ?? '') }}">
        </div>

    </div>
</div>


{{-- ================= GAJI ================= --}}
<div class="card mb-4">
    <div class="card-header fw-semibold">
        Gaji <span class="text-danger">*</span>
    </div>

    <div class="card-body d-flex align-items-center gap-2">
        <input type="number" name="gaji_min" class="form-control"
               value="{{ old('gaji_min',$lowongan->gaji_min ?? '') }}">
        <span>hingga</span>
        <input type="number" name="gaji_max" class="form-control"
               value="{{ old('gaji_max',$lowongan->gaji_max ?? '') }}">
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
             @foreach (['laki-laki'=>'Laki-laki','perempuan'=>'Perempuan'] as $val=>$label)
            <div>
                <input type="radio" name="jenis_kelamin" value="{{ $val }}"
                    {{ old('jenis_kelamin',$lowongan->jenis_kelamin ?? '') == $val ? 'checked' : '' }}>
                {{ $label }}
            </div>
        @endforeach
        </div>

        <label class="form-label fw-semibold">Usia</label>
        <div class="d-flex align-items-center gap-2 mb-2">
            <input type="number" name="usia_min" class="form-control"
                   value="{{ old('usia_min',$lowongan->usia_min ?? '') }}">
            <span>hingga</span>
            <input type="number" name="usia_max" class="form-control"
                   value="{{ old('usia_max',$lowongan->usia_max ?? '') }}">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input"
        type="checkbox"
        name="tanpa_batas_usia"
        value="1"
        {{ old('tanpa_batas_usia', $lowongan->tanpa_batas_usia ?? false) ? 'checked' : '' }}>
            Tidak ada batas usia
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">
                Skill Wajib Diisi
            </label>

            <select class="form-select select-skill" name="skills[]" multiple>
            @foreach ($skills as $skill)
                <option value="{{ $skill->id }}"
                    {{ isset($lowongan) && $lowongan->skills->contains($skill->id) ? 'selected' : '' }}>
                    {{ $skill->nama_skill }}
                </option>
            @endforeach
        </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">
                Pendidikan Minimal yang Dibutuhkan
            </label>
            <select name="pendidikan_minimal" class="form-select">
            @foreach (['SMA/SMK','D3','S1'] as $p)
                <option value="{{ $p }}"
                    {{ old('pendidikan_minimal',$lowongan->pendidikan_minimal ?? '') == $p ? 'selected' : '' }}>
                    {{ $p }}
                </option>
            @endforeach
        </select>
        </div>

        <div>
            <label class="form-label fw-semibold">
                Pengalaman Kerja yang Dibutuhkan
            </label>
            <select name="pengalaman_kerja" class="form-select">
            @foreach (['fresh_graduate','1-2_tahun','3_tahun_lebih'] as $p)
                <option value="{{ $p }}"
                    {{ old('pengalaman_kerja',$lowongan->pengalaman_kerja ?? '') == $p ? 'selected' : '' }}>
                    {{ str_replace('_',' ',$p) }}
                </option>
            @endforeach
        </select>
        </div>

    </div>
</div>

{{-- ================= ACTION BUTTON ================= --}}
<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('hrd.lowongan.index') }}" class="btn btn-light">Kembali</a>
    <button type="submit" class="btn btn-primary">Selanjutnya</button>
</div>

</form>

@endsection

@push('scripts')
<script>
$(function () {
    $('.select-skill').select2({
        placeholder: 'Cari & pilih skill',
        width: '100%'
    });
});
</script>
@endpush
