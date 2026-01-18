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
                <tr>
                    {{-- NAMA --}}
                    <td>{{ $k->user->name }}</td>

                    {{-- STATUS --}}
                    <td>
                        <span class="badge bg-warning text-dark">
                            {{ ucfirst($k->status) }}
                        </span>
                    </td>

                    {{-- TANGGAL --}}
                    <td>{{ $k->created_at->format('d M Y') }}</td>

                    {{-- ACTION --}}
                    <td class="text-center">
                        <a href="{{ route('hrd.kandidat.detail', [$lowongan, $k->id]) }}"
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
<link rel="stylesheet"
      href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

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
