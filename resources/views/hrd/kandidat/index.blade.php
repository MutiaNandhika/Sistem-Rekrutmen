@extends('layouts.hrd')

@section('title', 'Kelola Kandidat')

@section('breadcrumb')
<nav class="breadcrumb-wrapper">
    <a href="{{ route('lowongan.index') }}">Lowongan</a>
    <span>/</span>
    <span class="active">Kelola Kandidat</span>
</nav>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Kelola Kandidat</h4>

    <div class="d-flex gap-2">
        <button class="btn btn-primary">Screening</button>
        <button class="btn btn-dark">
            <i class="bi bi-file-earmark-text"></i> Lihat Laporan
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">

        <table id="kandidatTable" class="table kandidat-table align-middle w-100">
    <thead>
        <tr>
            <th>Nama Kandidat</th>
            <th>Status Seleksi</th>
            <th>Tanggal Melamar</th>
            <th>Pendidikan</th>
            <th>Pengalaman</th>
            <th>Keahlian</th>
            <th>Skor</th>
            <th>Ranking</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>

    <tbody>
    @foreach ($kandidats as $kandidat)
    <tr>
        <td class="fw-semibold">{{ $kandidat->nama }}</td>

        <td>
            <span class="badge 
                {{ $kandidat->status === 'Diterima' ? 'bg-success' : 'bg-warning text-dark' }}">
                {{ $kandidat->status }}
            </span>
        </td>

        <td>{{ \Carbon\Carbon::parse($kandidat->tanggal)->format('d M Y') }}</td>
        <td>{{ $kandidat->pendidikan }}</td>
        <td>{{ $kandidat->pengalaman }} th</td>
        <td>{{ $kandidat->keahlian }}</td>

        <td>
            <span class="badge bg-info text-dark">
                {{ $kandidat->skor }}
            </span>
        </td>

        <td>
            <span class="badge bg-primary">
                #{{ $kandidat->ranking }}
            </span>
        </td>

        <td>
            <a href="{{ route('hrd.kandidat.detail', [$lowongan, $kandidat->id]) }}"
            class="btn btn-sm btn-primary">
                Detail
            </a>
        </td>
    </tr>
    @endforeach
    </tbody>

</table>

    </div>
</div>

@endsection

@push('scripts')
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#kandidatTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 5,
        lengthChange: false,
        language: {
            search: "Cari:",
            paginate: {
                previous: "‹",
                next: "›"
            }
        }
    });
});
</script>
@endpush
