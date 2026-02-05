@extends('layouts.hrd')

@section('title', 'Kelola Kandidat')

@section('breadcrumb')
<nav class="breadcrumb-wrapper">
    <a href="{{ route('hrd.lowongan.index') }}">Lowongan</a>
    <span>/</span>
    <span class="active">Kelola Kandidat</span>
</nav>
@endsection

@section('content')

<div class="page-kelola-kandidat"><!-- 🔒 SCOPING WRAPPER -->

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Kelola Kandidat</h4>

    @if (!$isOwner)
        <div class="alert alert-info mb-4">
            Anda hanya dapat melihat data kandidat (read-only).
            Proses seleksi hanya dapat dilakukan oleh HRD pembuat lowongan.
        </div>
    @endif

    <div class="d-flex gap-2">
        @if ($isOwner)
            <a href="{{ route('hrd.seleksi.index', $lowongan) }}"
               class="btn btn-success">
                Halaman Seleksi
            </a>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body">

        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>

                    <optgroup label="Dalam Proses">
                        <option value="diproses" {{ request('status')=='diproses'?'selected':'' }}>Diproses</option>
                        <option value="screening" {{ request('status')=='screening'?'selected':'' }}>Screening</option>
                        <option value="seleksi" {{ request('status')=='seleksi'?'selected':'' }}>Seleksi (SAW)</option>
                        <option value="interview" {{ request('status')=='interview'?'selected':'' }}>Interview</option>
                        <option value="offer" {{ request('status')=='offer'?'selected':'' }}>Offer</option>
                    </optgroup>

                    <optgroup label="Selesai">
                        <option value="diterima" {{ request('status')=='diterima'?'selected':'' }}>
                            Selesai – Diterima
                        </option>
                        <option value="ditolak" {{ request('status')=='ditolak'?'selected':'' }}>
                            Selesai – Ditolak
                        </option>
                    </optgroup>
                </select>
            </div>
        </form>

        <table id="kandidatTable"
               class="table kandidat-table align-middle w-100">
            <thead>
                <tr>
                    <th>Nama Kandidat</th>
                    <th>Status Seleksi</th>
                    <th>Tanggal Melamar</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
            @foreach ($kandidats as $k)

                @php
                    $statusColor = [
                        'diproses' => 'secondary',
                        'screening' => 'info',
                        'seleksi' => 'primary',
                        'interview' => 'warning',
                        'offer' => 'dark',
                        'diterima' => 'success',
                        'ditolak' => 'danger',
                    ];
                @endphp

                <tr>
                    <td>{{ $k->user->name }}</td>

                    <td>
                        <span class="badge bg-{{ $statusColor[$k->status] ?? 'secondary' }}">
                            {{ strtoupper($k->status) }}
                        </span>
                    </td>

                    <td>{{ $k->created_at->format('d M Y') }}</td>

                    <td class="text-center">
                        <a href="{{ route('hrd.kandidat.detail', [$lowongan, $k->id]) }}"
                           class="btn btn-sm btn-primary">
                            Detail
                        </a>

                        <a href="{{ route('cv.download', $k->user_id) }}"
                           target="_blank"
                           class="btn btn-outline-dark btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Download CV
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>

</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#kandidatTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,

        pageLength: 5,
        lengthChange: true,
        lengthMenu: [5, 10, 25, 50],

        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            paginate: {
                previous: "‹",
                next: "›"
            }
        }
    });
});
</script>
@endpush

