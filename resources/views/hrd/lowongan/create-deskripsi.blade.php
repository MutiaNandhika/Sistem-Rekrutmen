@extends('layouts.hrd')

@section('title', 'Tambah Lowongan – Deskripsi')

@section('breadcrumb')
<nav class="breadcrumb-wrapper">
    <a href="{{ route('hrd.dashboard') }}">Dashboard</a>
    <span>/</span>
    <a href="{{ route('lowongan.index') }}">Lowongan</a>
    <span>/</span>
    <span class="active">Deskripsi Pekerjaan</span>
</nav>
@endsection

@section('content')

<h4 class="fw-bold text-center mb-4">Pasang Loker</h4>

{{-- STEP INDICATOR --}}
<div class="d-flex justify-content-center align-items-center gap-3 mb-4">

    {{-- STEP 1 (SUDAH DILEWATI, TETAP NYALA) --}}
    <div class="d-flex align-items-center gap-2">
        <span class="step-circle done">1</span>
        <span class="fw-semibold">Info Loker</span>
    </div>

    <div class="step-line"></div>

    {{-- STEP 2 (AKTIF) --}}
    <div class="d-flex align-items-center gap-2">
        <span class="step-circle active">2</span>
        <span class="fw-semibold">Deskripsi Pekerjaan</span>
    </div>

</div>


<form>

<div class="card mb-4">
    <div class="card-header fw-semibold">
        Deskripsi Pekerjaan <span class="text-danger">*</span>
    </div>

    <div class="card-body">
        <label class="form-label fw-semibold">Deskripsi</label>
        <textarea
            class="form-control"
            rows="5"
            placeholder="Jelaskan tanggung jawab pekerjaan..."></textarea>
    </div>
</div>

{{-- ACTION BUTTON --}}
<div class="d-flex justify-content-end gap-2 mb-5">

    <a href="{{ route('lowongan.create') }}"
       class="btn btn-light border">
        Sebelumnya
    </a>

    <button type="submit"
            class="btn btn-primary">
        Upload Loker
    </button>

    <button type="button"
            class="btn btn-warning text-white">
        Draft
    </button>

</div>

</form>

@endsection
