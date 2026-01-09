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

    <div class="d-flex gap-2">
        <form action="{{ route('hrd.kandidat.screening', $lowongan) }}" method="POST">
            @csrf
            <button class="btn btn-primary">
                Screening
            </button>
        </form>

        <a href="{{ route('hrd.laporan.index', $lowongan) }}"
           class="btn btn-dark">
            Lihat Laporan
        </a>
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
                    <th>Pendidikan</th>
                    <th>Pengalaman</th>
                    <th>Keahlian</th>
                    <th>Skor</th>
                    <th>Ranking</th>
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

                    <td>
                        {{
                            optional(
                                $k->user->pelamarEducations
                                    ->sortByDesc('created_at')
                                    ->first()
                            )->tingkat ?? '-'
                        }}
                    </td>

                    {{-- TOTAL PENGALAMAN (TAHUN) --}}
                    <td>
                        {{ $k->user->totalPengalamanTahun() }} th
                    </td>


                    {{-- JUMLAH SKILL --}}
                    <td>
                        {{ $k->user->pelamarSkills->count() }}
                    </td>

                    {{-- SKOR & RANK --}}
                    <td>{{ $k->saw_score ?? '-' }}</td>
                    <td>{{ $k->saw_rank ?? '-' }}</td>

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
