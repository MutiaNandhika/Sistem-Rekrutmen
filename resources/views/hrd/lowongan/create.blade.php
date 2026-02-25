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

<h4 class="fw-bold text-center mb-4">Pasang Loker</h4>

{{-- Step Indicator --}}
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
    action="{{ isset($lowongan) ? route('hrd.lowongan.update', $lowongan->id) : route('hrd.lowongan.store') }}"
    method="POST">
    @csrf
    @if(isset($lowongan)) @method('PUT') @endif

    {{-- Detail & Jenis Pekerjaan --}}
    <div class="card mb-4">
        <div class="card-header fw-semibold">
            Detail & Jenis Pekerjaan <span class="text-danger">*</span>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Nama Loker
                </label>
                <input
                    type="text"
                    name="nama_lowongan"
                    class="form-control"
                    value="{{ old('nama_lowongan', $lowongan->nama_lowongan ?? '') }}"
                    required>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label fw-semibold mb-0">
                        Bidang Kerja
                    </label>

                    <button
                        type="button"
                        class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalBidangKerja">
                        + Tambah Bidang Kerja
                    </button>
                </div>

                <select
                    name="bidang_kerja_id"
                    class="form-select select-bidang-kerja"
                    required>
                    <option value="">-- Pilih Bidang Kerja --</option>
                    @foreach ($bidangKerja as $bidang)
                        <option value="{{ $bidang->id }}"
                            {{ old('bidang_kerja_id', $lowongan->bidang_kerja_id ?? '') == $bidang->id ? 'selected' : '' }}>
                            {{ $bidang->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2">
                <label class="form-label fw-semibold mt-3">
                    Tipe Kerja
                </label>
                <select
                    name="tipe_kerja"
                    class="form-select"
                    required>
                    @foreach ([
                        'penuh_waktu' => 'Penuh Waktu',
                        'paruh_waktu' => 'Paruh Waktu',
                        'kontrak'     => 'Kontrak'
                    ] as $val => $label)
                        <option value="{{ $val }}"
                            {{ old('tipe_kerja', $lowongan->tipe_kerja ?? '') == $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>

    {{-- Periode Pendaftaran --}}
    <div class="card mb-4">
        <div class="card-header fw-semibold">
            Periode Pendaftaran <span class="text-danger">*</span>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Tanggal Mulai Pendaftaran <span class="text-danger">*</span>
                    </label>
                    <input
                        type="date"
                        name="tanggal_mulai"
                        class="form-control"
                        value="{{ old('tanggal_mulai', optional($lowongan)->tanggal_mulai?->format('Y-m-d')) }}"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Tanggal Selesai Pendaftaran <span class="text-danger">*</span>
                    </label>
                    <input
                        type="date"
                        name="tanggal_selesai"
                        class="form-control"
                        value="{{ old('tanggal_selesai', optional($lowongan)->tanggal_selesai?->format('Y-m-d')) }}"
                        required>
                </div>
            </div>
        </div>
    </div>


    {{-- Lokasi --}}
    <div class="card mb-4">
        <div class="card-header fw-semibold">
            Lokasi <span class="text-danger">*</span>
        </div>

        <div class="card-body">

            <label class="form-label fw-semibold">Sistem Kerja</label>
            <div class="d-flex gap-4 mb-3">
                @foreach ([
                    'kantor' => 'Di Kantor',
                    'remote' => 'Remote',
                    'hybrid' => 'Hybrid'
                ] as $val => $label)
                    <div>
                        <input
                            type="radio"
                            name="sistem_kerja"
                            value="{{ $val }}"
                            {{ old('sistem_kerja', $lowongan->sistem_kerja ?? '') == $val ? 'checked' : '' }}
                            required>
                        {{ $label }}
                    </div>
                @endforeach
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Lokasi</label>
                <input
                    type="text"
                    name="lokasi"
                    class="form-control"
                    value="{{ old('lokasi', $lowongan->lokasi ?? '') }}"
                    required>
            </div>

            <div>
                <label class="form-label fw-semibold">Penempatan Kerja</label>
                <input
                    type="text"
                    name="penempatan"
                    class="form-control"
                    placeholder="Contoh: Perusahaan Klien (Manufaktur)"
                    value="{{ old('penempatan', $lowongan->penempatan ?? '') }}">
            </div>

        </div>
    </div>


    {{-- Gaji --}}
    <div class="card mb-4">
        <div class="card-header fw-semibold">
            Gaji <span class="text-danger">*</span>
        </div>

        <div class="card-body d-flex align-items-center gap-2">
            <input
                type="number"
                name="gaji_min"
                class="form-control"
                value="{{ old('gaji_min', $lowongan->gaji_min ?? '') }}">

            <span>hingga</span>

            <input
                type="number"
                name="gaji_max"
                class="form-control"
                value="{{ old('gaji_max', $lowongan->gaji_max ?? '') }}">
        </div>
    </div>

    {{-- Persyaratan Kerja --}}
    <div class="card mb-4">
        <div class="card-header fw-semibold">
            Persyaratan Kerja <span class="text-danger">*</span>
        </div>

        <div class="card-body">

            <label class="form-label fw-semibold">Jenis Kelamin</label>
            <div class="d-flex gap-4 mb-3">
                @foreach ([
                    'laki-laki' => 'Laki-laki',
                    'perempuan' => 'Perempuan',
                    'semua' => 'Laki-laki & Perempuan'
                ] as $val => $label)
                    <div>
                        <input
                            type="radio"
                            name="jenis_kelamin"
                            value="{{ $val }}"
                            {{ old('jenis_kelamin', $lowongan->jenis_kelamin ?? 'semua') == $val ? 'checked' : '' }}>
                        {{ $label }}
                    </div>
                @endforeach
            </div>

            <label class="form-label fw-semibold">Usia</label>
            <div class="d-flex align-items-center gap-2 mb-2">
                <input
                    type="number"
                    name="usia_min"
                    class="form-control"
                    value="{{ old('usia_min', $lowongan->usia_min ?? '') }}">

                <span>hingga</span>

                <input
                    type="number"
                    name="usia_max"
                    class="form-control"
                    value="{{ old('usia_max', $lowongan->usia_max ?? '') }}">
            </div>

            <div class="form-check mb-3">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="tanpa_batas_usia"
                    value="1"
                    {{ old('tanpa_batas_usia', $lowongan->tanpa_batas_usia ?? false) ? 'checked' : '' }}>
                Tidak ada batas usia
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label fw-semibold mb-0">
                        Skill Wajib Diisi
                    </label>

                    <button
                        type="button"
                        class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalSkill">
                        + Tambah Skill
                    </button>
                </div>

                <select
                    class="form-select select-skill"
                    name="skills[]"
                    multiple>
                    @foreach ($skills as $skill)
                        <option
                            value="{{ $skill->id }}"
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
                    @foreach (['SMA/SMK', 'D3', 'S1'] as $p)
                        <option
                            value="{{ $p }}"
                            {{ old('pendidikan_minimal', $lowongan->pendidikan_minimal ?? '') == $p ? 'selected' : '' }}>
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
                    @foreach (['Fresh_Graduate', '1-2_Tahun', '3_Tahun_Lebih'] as $p)
                        <option
                            value="{{ $p }}"
                            {{ old('pengalaman_kerja', $lowongan->pengalaman_kerja ?? '') == $p ? 'selected' : '' }}>
                            {{ str_replace('_', ' ', $p) }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Jumlah Kandidat Diterima</label>
        <input type="number"
            name="jumlah_diterima"
            class="form-control"
            min="1"
            value="{{ old('jumlah_diterima', $lowongan->jumlah_diterima ?? 1) }}"
            required>
        <small class="text-muted">
            Sistem akan otomatis menentukan jumlah interview (3x lipat).
        </small>
    </div>


    {{-- ================= ACTION BUTTON ================= --}}
    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('hrd.lowongan.index') }}" class="btn btn-light">Kembali</a>
        <button type="submit" class="btn btn-primary">Selanjutnya</button>
    </div>

</form>

<div class="modal fade" id="modalSkill" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Skill</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="text"
                       id="skillName"
                       class="form-control"
                       placeholder="Contoh: Leadership">
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="saveHrdSkill()">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalEditSkill" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Skill</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="editSkillId">
                <input type="text" id="editSkillName" class="form-control">
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button class="btn btn-danger" onclick="deleteHrdSkill()">Hapus</button>
                <button class="btn btn-primary" onclick="updateHrdSkill()">Simpan</button>
            </div>

        </div>
    </div>
</div>

{{-- Modal Tambah Bidang Kerja --}}
<div class="modal fade" id="modalBidangKerja" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Bidang Kerja</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="text"
                       id="bidangKerjaName"
                       class="form-control"
                       placeholder="Contoh: Finance">
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" onclick="saveBidangKerja()">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>

{{-- Modal Edit Bidang Kerja --}}
<div class="modal fade" id="modalEditBidangKerja" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Bidang Kerja</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="editBidangKerjaId">
                <input type="text" id="editBidangKerjaName" class="form-control">
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button class="btn btn-danger" onclick="deleteBidangKerja()">Hapus</button>
                <button class="btn btn-primary" onclick="updateBidangKerja()">Simpan</button>
            </div>

        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
/* Select2 Initialization */
$(function () {
    $('.select-skill').select2({
        placeholder: 'Cari & pilih skill',
        width: '100%'
    });

    $('.select-bidang-kerja').select2({
        placeholder: 'Pilih bidang kerja',
        width: '100%'
    });
});


/* Create Skill */
function saveHrdSkill() {
    const name = document.getElementById('skillName').value.trim();

    if (!name) {
        Swal.fire('Oops', 'Nama skill wajib diisi', 'warning');
        return;
    }

    fetch('/hrd/skills', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ nama_skill: name })
    })
    .then(res => {
        if (!res.ok) throw new Error('Skill sudah ada');
        return res.json();
    })
    .then(skill => {
        const option = new Option(skill.nama_skill, skill.id, true, true);
        $('.select-skill').append(option).trigger('change');

        document.getElementById('skillName').value = '';
        bootstrap.Modal.getInstance(document.getElementById('modalSkill')).hide();

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Skill berhasil ditambahkan',
            timer: 2000,
            showConfirmButton: false
        });
    })
    .catch(err => Swal.fire('Gagal', err.message, 'error'));
}


/* Open Edit Modal */
$('.select-skill').on('select2:select', function (e) {
    const data = e.params.data;

    document.getElementById('editSkillId').value = data.id;
    document.getElementById('editSkillName').value = data.text.trim();

    new bootstrap.Modal(document.getElementById('modalEditSkill')).show();
});


/* Update Skill */
function updateHrdSkill() {
    const id   = document.getElementById('editSkillId').value;
    const name = document.getElementById('editSkillName').value.trim();

    if (!name) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops',
            text: 'Nama skill wajib diisi'
        });
        return;
    }

    fetch(`/hrd/skills/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            _method: 'PUT',
            nama_skill: name
        })
    })
    .then(async res => {
        if (!res.ok) {
            const data = await res.json();
            throw new Error(data.message || 'Gagal update skill');
        }
        return res.json();
    })
    .then(skill => {
        const oldOption = $('.select-skill option[value="' + skill.id + '"]');
        const isSelected = oldOption.is(':selected');
        
        // Buat option baru untuk me-reset cache internal Select2
        const newOption = new Option(skill.nama_skill, skill.id, isSelected, isSelected);
        oldOption.replaceWith(newOption);

        $('.select-skill').trigger('change');

        bootstrap.Modal
            .getInstance(document.getElementById('modalEditSkill'))
            .hide();

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Skill berhasil diperbarui',
            timer: 2000,
            showConfirmButton: false
        });
    })
    .catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: err.message
        });
    });
}


/* Delete Skill */
function deleteHrdSkill() {
    const id = document.getElementById('editSkillId').value;

    Swal.fire({
        title: 'Yakin hapus skill?',
        text: 'Skill yang sudah dipakai tidak bisa dihapus',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then(result => {
        if (!result.isConfirmed) return;

        fetch(`/hrd/skills/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(async res => {
            if (!res.ok) {
                const data = await res.json();
                throw new Error(data.message || 'Skill masih digunakan');
            }
            return res.json();
        })
        .then(() => {
            $('.select-skill option[value="' + id + '"]').remove();
            $('.select-skill').trigger('change');

            bootstrap.Modal
                .getInstance(document.getElementById('modalEditSkill'))
                .hide();

            Swal.fire('Berhasil', 'Skill berhasil dihapus', 'success');
        })
        .catch(err => Swal.fire('Gagal', err.message, 'error'));
    });
}

/* Bidang Kerja CRUD */
function saveBidangKerja() {
    const name = document.getElementById('bidangKerjaName').value.trim();

    if (!name) {
        Swal.fire('Oops', 'Nama bidang kerja wajib diisi', 'warning');
        return;
    }

    fetch('/hrd/bidang-kerja', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ nama: name })
    })
    .then(res => {
        if (!res.ok) throw new Error('Bidang kerja sudah ada');
        return res.json();
    })
    .then(bidang => {
        const option = new Option(bidang.nama, bidang.id, true, true);
        $('.select-bidang-kerja').append(option).trigger('change');

        document.getElementById('bidangKerjaName').value = '';
        bootstrap.Modal.getInstance(document.getElementById('modalBidangKerja')).hide();

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Bidang kerja berhasil ditambahkan',
            timer: 2000,
            showConfirmButton: false
        });
    })
    .catch(err => Swal.fire('Gagal', err.message, 'error'));
}


/* Open Edit Modal */
$('.select-bidang-kerja').on('select2:select', function (e) {
    const data = e.params.data;

    document.getElementById('editBidangKerjaId').value = data.id;
    document.getElementById('editBidangKerjaName').value = data.text.trim();

    new bootstrap.Modal(document.getElementById('modalEditBidangKerja')).show();
});


/* Update Bidang Kerja */
function updateBidangKerja() {
    const id   = document.getElementById('editBidangKerjaId').value;
    const name = document.getElementById('editBidangKerjaName').value.trim();

    fetch(`/hrd/bidang-kerja/${id}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ nama: name })
    })
    .then(res => {
        if (!res.ok) throw new Error('Gagal update bidang kerja');
        return res.json();
    })
    .then(bidang => {
        const option = new Option(bidang.nama, bidang.id, true, true);
        $('.select-bidang-kerja option[value="' + bidang.id + '"]').replaceWith(option);
        $('.select-bidang-kerja').trigger('change');

        bootstrap.Modal.getInstance(document.getElementById('modalEditBidangKerja')).hide();

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Bidang kerja berhasil diperbarui',
            timer: 2000,
            showConfirmButton: false
        });
    })
    .catch(err => Swal.fire('Gagal', err.message, 'error'));
}


/* Delete Bidang Kerja */
function deleteBidangKerja() {
    const id = document.getElementById('editBidangKerjaId').value;

    Swal.fire({
        title: 'Yakin hapus bidang kerja?',
        text: 'Bidang kerja yang masih dipakai tidak bisa dihapus',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then(result => {
        if (!result.isConfirmed) return;

        fetch(`/hrd/bidang-kerja/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => {
            if (!res.ok) throw new Error('Bidang kerja masih dipakai lowongan');
            return res.json();
        })
        .then(() => {
            $('.select-bidang-kerja option[value="' + id + '"]').remove();
            $('.select-bidang-kerja').trigger('change');

            bootstrap.Modal.getInstance(document.getElementById('modalEditBidangKerja')).hide();

            Swal.fire('Berhasil', 'Bidang kerja berhasil dihapus', 'success');
        })
        .catch(err => Swal.fire('Gagal', err.message, 'error'));
    });
}

</script>
@endpush
