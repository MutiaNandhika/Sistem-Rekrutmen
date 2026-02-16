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

<div class="page-seleksi-kandidat">

<h4 class="fw-bold mb-3">Seleksi Kandidat (Metode SAW)</h4>

{{-- ================= ACTION BUTTON ================= --}}
<div class="d-flex gap-2 mb-4">

    @if($sawDone)
        <button class="btn btn-secondary" disabled>
            SAW sudah dihitung
        </button>
    @else
        <form method="POST" action="{{ route('hrd.seleksi.hitung', $lowongan) }}">
            @csrf
            <button class="btn btn-primary">Hitung SAW</button>
        </form>
    @endif

    @if($sawDone)
        <form method="POST"
              action="{{ route('hrd.seleksi.reset', $lowongan) }}"
              class="form-reset-saw">
            @csrf
            @method('PUT')
            <button class="btn btn-outline-danger">Reset SAW</button>
        </form>
    @endif

    <a href="{{ route('hrd.laporan.index', $lowongan) }}"
       class="btn btn-dark">
        Lihat Laporan
    </a>
</div>

<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <table id="table-saw"
                   class="table kandidat-table align-middle w-100">
                <thead>
                <tr>
                    <th>Nama Kandidat</th>
                    <th>Pendidikan</th>
                    <th>Pengalaman (th)</th>
                    <th>Skill</th>
                    <th>Skor SAW</th>
                    <th>Ranking</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($apps as $app)
                    <tr>
                        <td>{{ $app->snap_name ?? $app->user->name }}</td>

                        <td>
                            {{ $app->snap_pendidikan_nilai ?? '-' }}
                        </td>

                        <td>
                            {{ $app->snap_pengalaman_tahun ?? 0 }}
                        </td>

                        <td>
                            {{ $app->snap_total_skill ?? 0 }}
                        </td>

                        <td>
                            {{ $app->saw_score !== null ? number_format($app->saw_score, 3) : '-' }}
                        </td>

                        <td>
                            {{ $app->saw_rank ?? '-' }}
                        </td>

                        <td>
                            @if ($app->status === 'seleksi')
                                <span class="badge bg-secondary">Menunggu SAW</span>
                            @elseif ($app->status === 'interview')
                                <span class="badge bg-success">Lolos SAW (Interview)</span>
                            @elseif ($app->status === 'tidak_lolos_saw')
                                <span class="badge bg-danger">Tidak Lolos SAW</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#table-saw').DataTable({
        paging: true,
        searching: true,
        ordering: true,

        pageLength: 5,
        lengthChange: true,
        lengthMenu: [5, 10, 25, 50],

        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ kandidat",
            paginate: {
                previous: "‹",
                next: "›"
            }
        }
    });
});

$(document).ready(function () {

    $('.form-reset-saw').on('submit', function (e) {
        e.preventDefault();

        const form = this;

        Swal.fire({
            title: 'Reset hasil SAW?',
            text: 'Semua hasil perhitungan SAW akan dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, reset',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

});
</script>
@endpush

