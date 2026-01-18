@extends('layouts.hrd')

@section('title','Seleksi Kandidat (SAW)')

@section('breadcrumb')
<nav class="breadcrumb-wrapper">
    <a href="{{ route('hrd.lowongan.index') }}">Lowongan</a>
    <span>/</span>
    <a href="{{ route('hrd.kandidat.index', $lowongan) }}">Kelola Kandidat</a>
    <span>/</span>
    <span class="active">Seleksi (SAW)</span>
</nav>
@endsection

@section('content')

<h4 class="fw-bold mb-3">Seleksi Kandidat (Metode SAW)</h4>

<div class="d-flex gap-2 mb-4">

    {{-- HITUNG SAW --}}
    @if($sawDone)
        <button class="btn btn-secondary" disabled>
            SAW sudah dihitung
        </button>
    @else
        <form method="POST"
              action="{{ route('hrd.seleksi.hitung', $lowongan) }}">
            @csrf
            <button class="btn btn-primary">
                Hitung SAW
            </button>
        </form>
    @endif

    {{-- RESET SAW --}}
    @if($sawDone)
        <form method="POST"
              action="{{ route('hrd.seleksi.reset', $lowongan) }}"
              onsubmit="return confirm('Yakin ingin reset hasil SAW?')">
            @csrf
            @method('PUT')
            <button class="btn btn-outline-danger">
                Reset SAW
            </button>
        </form>
    @endif

    {{-- LAPORAN --}}
    <a href="{{ route('hrd.laporan.index', $lowongan) }}"
       class="btn btn-dark">
        Lihat Laporan
    </a>
</div>


<table class="table table-bordered align-middle">
<thead class="table-light">
<tr>
    <th>Nama Kandidat</th>
    <th>Pendidikan</th>
    <th>Pengalaman (th)</th>
    <th>Skill</th>
    <th>Skor SAW</th>
    <th>Ranking</th>
</tr>
</thead>

<tbody>
@forelse ($apps as $app)
<tr>
    <td>{{ $app->user->name }}</td>
    <td>{{ $app->user->nilaiPendidikanTerakhir() }}</td>
    <td>{{ $app->user->totalPengalamanTahun() }}</td>
    <td>{{ $app->user->pelamarSkills->count() }}</td>
    <td>{{ $app->saw_score ?? '-' }}</td>
    <td>{{ $app->saw_rank ?? '-' }}</td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center text-muted">
        Belum ada kandidat di tahap seleksi
    </td>
</tr>
@endforelse
</tbody>
</table>

@endsection
