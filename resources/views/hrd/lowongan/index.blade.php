@extends('layouts.hrd')

@section('title', 'Daftar Lowongan Kerja')

@section('content')

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Daftar Lowongan Kerja</h4>

    <a href="#" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i>
        Tambah Lowongan Kerja
    </a>
</div>

{{-- FILTER TABS --}}
<div class="card mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">

        <ul class="nav nav-tabs lowongan-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    Semua Loker <span class="badge">15</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    Aktif <span class="badge">7</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    Nonaktif <span class="badge">8</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    Draft <span class="badge">8</span>
                </a>
            </li>
        </ul>

        <button class="btn btn-light border">
            <i class="bi bi-arrow-down-up"></i>
            Urutkan: Tanggal Diupdate
        </button>
    </div>
</div>

{{-- LIST LOWONGAN --}}
<div class="lowongan-list">

    @forelse ($lowongans as $lowongan)
        <div class="lowongan-card {{ $lowongan->status === 'aktif' ? 'active' : '' }}">

            {{-- HEADER --}}
            <div class="lowongan-header">
                <h6>{{ $lowongan->judul }}</h6>

                <span
                    class="status-badge {{ $lowongan->status }}"
                    data-id="{{ $lowongan->id }}"
                    data-status="{{ $lowongan->status }}"
                    onclick="toggleStatus(this)"
                >
                    {{ ucfirst($lowongan->status) }}
                </span>
            </div>

            {{-- META --}}
            <ul class="lowongan-meta">
                <li>
                    <i class="bi bi-building"></i>
                    {{ $lowongan->perusahaan }}
                </li>
                <li>
                    <i class="bi bi-briefcase"></i>
                    {{ $lowongan->tipe_pekerjaan }}
                </li>
                <li>
                    <i class="bi bi-geo-alt"></i>
                    {{ $lowongan->lokasi }}
                </li>
            </ul>

            {{-- ACTIONS --}}
            <div class="lowongan-actions">
                <a href="#"
                class="btn-dashboard orange sm">
                    Detail Lowongan
                </a>

                <a href="#"
                class="btn-dashboard blue sm">
                    Kelola Kandidat
                </a>

                <button class="btn btn-delete">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

        </div>
    @empty
        <div class="text-center text-muted py-5">
            Belum ada lowongan kerja.
        </div>
    @endforelse

</div>

@endsection

{{-- ================= SCRIPT ================= --}}
@push('scripts')
<script>
function toggleStatus(el) {

    const currentStatus = el.dataset.status;

    const nextStatus = currentStatus === 'aktif'
        ? 'nonaktif'
        : 'aktif';

    const nextStatusText = nextStatus === 'aktif'
        ? 'mengaktifkan'
        : 'menonaktifkan';

    const confirmAction = confirm(
        `Apakah anda yakin ingin ${nextStatusText} lowongan ini?`
    );

    if (!confirmAction) return;

    //  UPDATE UI LANGSUNG (FRONTEND ONLY)
    el.dataset.status = nextStatus;
    el.textContent = nextStatus.charAt(0).toUpperCase() + nextStatus.slice(1);

    el.classList.remove('aktif', 'nonaktif');
    el.classList.add(nextStatus);

    // OPTIONAL: ubah style card
    const card = el.closest('.lowongan-card');
    if (card) {
        card.classList.toggle('active', nextStatus === 'aktif');
    }
}
</script>
@endpush
