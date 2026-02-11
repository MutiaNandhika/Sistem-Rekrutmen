@extends('layouts.hrd')

@section('title', 'Tambah Lowongan – Deskripsi')

@section('breadcrumb')
<nav class="breadcrumb-wrapper">
    <a href="{{ route('hrd.dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('hrd.lowongan.index') }}">Lowongan</a>
    <span>/</span>
    <span class="active">Deskripsi Pekerjaan</span>
</nav>
@endsection

@section('content')

<h4 class="fw-bold text-center mb-4">Pasang Loker</h4>

{{-- STEP INDICATOR --}}
<div class="d-flex justify-content-center align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-2">
        <span class="step-circle done">1</span>
        <span class="fw-semibold">Info Loker</span>
    </div>
    <div class="step-line"></div>
    <div class="d-flex align-items-center gap-2">
        <span class="step-circle active">2</span>
        <span class="fw-semibold">Deskripsi Pekerjaan</span>
    </div>
</div>

<form method="POST"
      action="{{ route('hrd.lowongan.deskripsi.update', $lowongan->id) }}">
    @csrf
    @method('PUT')

    <div class="card mb-4">
        <div class="card-header fw-semibold">
            Deskripsi Pekerjaan <span class="text-danger">*</span>
        </div>

        <div class="card-body">
            <label class="form-label fw-semibold">Deskripsi</label>

            <textarea name="deskripsi_pekerjaan"
                      class="form-control"
                      rows="8"
                      required>{{ old('deskripsi_pekerjaan', $lowongan->deskripsi_pekerjaan) }}</textarea>
        </div>
    </div>

    <div class="d-flex justify-content-between mb-5">
        <button type="submit"
                name="action"
                value="back"
                class="btn btn-light border">
            Sebelumnya
        </button>
        <div class="d-flex gap-2">
            <button type="submit"
                    name="action"
                    value="draft"
                    class="btn btn-warning text-white">
                Simpan Draft
            </button>
            <button type="submit"
                    name="action"
                    value="publish"
                    class="btn btn-primary">
                Upload Loker
            </button>
        </div>

    </div>

</form>

@endsection
