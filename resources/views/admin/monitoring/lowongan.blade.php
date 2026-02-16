@extends('layouts.admin')

@section('title', 'Monitoring Lowongan')

@section('content')

<div class="page-monitoring-lowongan">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Monitoring Lowongan</h4>
        <p class="text-muted small mb-0">
            Admin hanya dapat melihat data lowongan (read-only) untuk keperluan monitoring.
        </p>
    </div>
</div>

{{-- Filter --}}
<div class="card shadow-sm mb-3">
    <div class="card-body py-3">
        <div class="row g-3 align-items-end">

            <div class="col-md-4">
                <label class="form-label small fw-semibold">
                    Filter HRD / PIC
                </label>
                <select id="filterHrd" class="form-select form-select-sm">
                    <option value="">Semua HRD</option>
                    @foreach ($hrds as $hrd)
                        <option value="{{ $hrd->name }}">
                            {{ $hrd->name }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>
</div>

{{-- Table --}}
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="lowonganTable">
                <thead class="table-light">
                    <tr>
                        <th>Nama Lowongan</th>
                        <th>Bidang Kerja</th>
                        <th>HRD / PIC</th>
                        <th>Status</th>
                        <th>Pelamar</th>
                        <th>Jumlah Dibutuhkan</th>
                        <th>Tanggal Dibuat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($lowongans as $lowongan)
                        <tr>
                            <td>
                                <strong>{{ $lowongan->nama_lowongan }}</strong><br>
                                <small class="text-muted">
                                    {{ $lowongan->lokasi }}
                                </small>
                            </td>

                            <td>
                                {{ $lowongan->bidangKerja->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $lowongan->hrd->name ?? '-' }}<br>
                                <small class="text-muted">
                                    {{ $lowongan->hrd->email ?? '' }}
                                </small>
                            </td>

                            <td>
                                @php
                                    $badge = match($lowongan->status) {
                                        'aktif'    => 'bg-success',
                                        'draft'    => 'bg-secondary',
                                        'nonaktif' => 'bg-warning text-dark',
                                        'arsip'    => 'bg-dark',
                                        default    => 'bg-light text-dark',
                                    };
                                @endphp

                                <span class="badge {{ $badge }}">
                                    {{ ucfirst($lowongan->status) }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $count = $lowongan->applications_count;
                                    $badgePelamar = match (true) {
                                        $count === 0 => 'bg-light text-dark border',
                                        $count < 5   => 'bg-info',
                                        $count < 10  => 'bg-primary',
                                        default      => 'bg-warning',
                                    };
                                @endphp

                                <span class="badge {{ $badgePelamar }}">
                                    {{ $count }} pelamar
                                </span>
                            </td>

                            <td>
                                {{ $lowongan->jumlah_diterima }} orang
                            </td>

                            <td>
                                {{ $lowongan->created_at->format('d M Y') }}
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.monitoring.lowongan.detail', $lowongan) }}"
                                   class="btn btn-secondary btn-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
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

{{-- Script --}}
@push('scripts')
<script>
$(document).ready(function () {
    const table = $('#lowonganTable').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        ordering: true,
        responsive: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_–_END_ dari _TOTAL_ data",
            zeroRecords: "Data tidak ditemukan",
            paginate: {
                previous: "‹",
                next: "›"
            }
        },
        columnDefs: [
            { orderable: false, targets: 7 } 
        ]
    });

    // FILTER HRD
    $('#filterHrd').on('change', function () {
        const value = $(this).val();
        table.column(2).search(value).draw();
    });

});
</script>
@endpush

