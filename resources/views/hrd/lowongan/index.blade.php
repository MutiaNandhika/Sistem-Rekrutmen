@extends('layouts.hrd')

@section('title', 'Daftar Lowongan Kerja')

@php
    // ================= COUNTER =================
    $total = $lowongans->count();
    $aktif = $lowongans->where('status', 'aktif')->count();
    $nonaktif = $lowongans->where('status', 'nonaktif')->count();
    $draft = $lowongans->where('status', 'draft')->count();
@endphp

@section('content')

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">Daftar Lowongan Kerja</h4>

    <a href="{{ route('lowongan.create') }}"
    class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i>
        Tambah Lowongan Kerja
    </a>
</div>

{{-- FILTER TABS --}}
<div class="card mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">

        <ul class="nav nav-tabs lowongan-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#" data-filter="all">
                    Semua Loker
                    <span class="badge" data-count="total">{{ $total }}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#" data-filter="aktif">
                    Aktif
                    <span class="badge" data-count="aktif">{{ $aktif }}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#" data-filter="nonaktif">
                    Nonaktif
                    <span class="badge" data-count="nonaktif">{{ $nonaktif }}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#" data-filter="arsip">
                    Arsip
                    <span class="badge" data-count="arsip">0</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#" data-filter="draft">
                    Draft
                    <span class="badge" data-count="draft">{{ $draft }}</span>
                </a>
            </li>
        </ul>

        <button
            id="sortButton"
            class="btn btn-light border"
            data-order="desc"
        >
            <i class="bi bi-arrow-down-up"></i>
            Urutkan: Terbaru
        </button>

    </div>
</div>

{{-- LIST LOWONGAN --}}
<div class="lowongan-list">

    @forelse ($lowongans as $lowongan)
        <div class="lowongan-card {{ $lowongan->status === 'aktif' ? 'active' : '' }}"
     data-status="{{ $lowongan->status }}"
     data-updated="{{ $lowongan->updated_at ?? '2025-01-01' }}">


            {{-- HEADER --}}
            <div class="lowongan-header d-flex justify-content-between align-items-start">
                <div>
                    <h6>{{ $lowongan->judul }}</h6>
                    <small class="text-muted">
                        <i class="bi bi-clock"></i>
                        {{ \Carbon\Carbon::parse($lowongan->updated_at ?? '2025-01-01')->translatedFormat('d M Y') }}
                    </small>
                </div>

                <span class="status-badge {{ $lowongan->status }}">
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

            <div class="lowongan-actions">

    {{-- LEFT ACTIONS --}}
    <div class="left-actions">
        <a href="#" class="btn-dashboard orange sm">
            Detail Lowongan
        </a>

        <a href="{{ route('lowongan.kandidat', $lowongan->id) }}"
        class="btn-dashboard blue sm">
            Kelola Kandidat
        </a>

    </div>

    {{-- RIGHT ICON ACTIONS --}}
    <div class="right-actions action-icons">

        {{-- EDIT --}}
        <a href="#"
           class="action-btn edit"
           title="Edit Lowongan">
            <i class="bi bi-pencil"></i>
        </a>

        {{-- DELETE --}}
        <button class="action-btn delete"
                onclick="deleteLowongan(this)"
                title="Hapus Lowongan">
            <i class="bi bi-trash"></i>
        </button>

        {{-- DROPDOWN --}}
        <div class="dropdown">
            <button class="action-btn more"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    title="Aksi Lainnya">
                <i class="bi bi-three-dots"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end action-menu">
                {{-- diisi oleh JS --}}
            </ul>
        </div>

    </div>

</div>


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

/* ================= FILTER ================= */
document.querySelectorAll('.lowongan-tabs .nav-link').forEach(tab => {
    tab.addEventListener('click', e => {
        e.preventDefault();

        const filter = tab.dataset.filter;

        document.querySelectorAll('.lowongan-tabs .nav-link')
            .forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        document.querySelectorAll('.lowongan-card').forEach(card => {
            card.style.display =
            filter === 'all'
                ? card.dataset.status !== 'arsip'
                    ? 'block'
                    : 'none'
                : card.dataset.status === filter
                    ? 'block'
                    : 'none';

                });
    });
});

/* ================= SORT ================= */
document.getElementById('sortButton').addEventListener('click', function () {
    const list = document.querySelector('.lowongan-list');
    const cards = [...list.children];
    const order = this.dataset.order;

    cards.sort((a, b) =>
        order === 'desc'
            ? new Date(b.dataset.updated) - new Date(a.dataset.updated)
            : new Date(a.dataset.updated) - new Date(b.dataset.updated)
    );

    cards.forEach(card => list.appendChild(card));

    this.dataset.order = order === 'desc' ? 'asc' : 'desc';
    this.innerHTML =
        order === 'desc'
            ? `<i class="bi bi-arrow-up"></i> Urutkan: Terlama`
            : `<i class="bi bi-arrow-down"></i> Urutkan: Terbaru`;
});

/* ================= COUNTER ================= */
function updateCounters() {
    const cards = document.querySelectorAll('.lowongan-card');

    let total = 0;
    let aktif = 0, nonaktif = 0, draft = 0, arsip = 0;

    cards.forEach(card => {
        const status = card.dataset.status;

        if (status !== 'arsip') total++;

        if (status === 'aktif') aktif++;
        if (status === 'nonaktif') nonaktif++;
        if (status === 'draft') draft++;
        if (status === 'arsip') arsip++;
    });

    document.querySelector('[data-count="total"]').textContent = total;
    document.querySelector('[data-count="aktif"]').textContent = aktif;
    document.querySelector('[data-count="nonaktif"]').textContent = nonaktif;
    document.querySelector('[data-count="draft"]').textContent = draft;
    document.querySelector('[data-count="arsip"]').textContent = arsip;
}

function deleteLowongan(btn) {

    if (!confirm('Apakah anda yakin ingin menghapus lowongan ini?')) {
        return;
    }

    // ambil card terdekat
    const card = btn.closest('.lowongan-card');

    if (!card) return;

    // 🔥 tambahkan class animasi
    card.classList.add('removing');

    // ⏳ tunggu animasi, lalu hapus
    setTimeout(() => {
        card.remove();

        // update counter tab
        updateCounters();

        // re-apply filter aktif
        document
            .querySelector('.lowongan-tabs .nav-link.active')
            ?.click();

    }, 200);
}

function publishLowongan(btn) {
    if (!confirm('Publish lowongan ini?')) return;
    updateStatus(btn.closest('.lowongan-card'), 'aktif');
}

function deactivateLowongan(btn) {
    if (!confirm('Nonaktifkan lowongan ini?')) return;
    updateStatus(btn.closest('.lowongan-card'), 'nonaktif');
}

function activateLowongan(btn) {
    if (!confirm('Aktifkan kembali lowongan ini?')) return;
    updateStatus(btn.closest('.lowongan-card'), 'aktif');
}

function archiveLowongan(btn) {
    if (!confirm('Arsipkan lowongan ini?')) return;

    updateStatus(btn.closest('.lowongan-card'), 'arsip');
}

function updateStatus(card, status) {
    if (!card) return;

    // update status dataset
    card.dataset.status = status;

    // update class aktif
    card.classList.toggle('active', status === 'aktif');

    // update badge status (jika ada)
    const badge = card.querySelector('.status-badge');
    if (badge) {
        badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        badge.className = `status-badge ${status}`;
    }

    // 🔥 render ulang dropdown sesuai status baru
    renderDropdown(card);

    // update counter
    updateCounters();

    // re-apply filter aktif
    document
        .querySelector('.lowongan-tabs .nav-link.active')
        ?.click();
}

    function renderDropdown(card) {
    const status = card.dataset.status;
    const menu = card.querySelector('.action-menu');

    if (!menu) return;

    let html = '';

    if (status === 'draft') {
        html = `
            <li>
                <button type="button" class="dropdown-item"
                        onclick="publishLowongan(this)">
                    Publish
                </button>
            </li>
        `;
    }

    if (status === 'aktif') {
        html = `
            <li>
                <button type="button" class="dropdown-item text-warning"
                        onclick="deactivateLowongan(this)">
                    Nonaktifkan
                </button>
            </li>
        `;
    }

    if (status === 'nonaktif') {
        html = `
            <li>
                <button type="button" class="dropdown-item text-success"
                        onclick="activateLowongan(this)">
                    Aktifkan
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item text-muted"
                        onclick="archiveLowongan(this)">
                    Arsip
                </button>
            </li>
        `;
    }

    if (status === 'arsip') {
    html = `
        <li class="dropdown-item text-muted">
            Tidak ada aksi
        </li>
    `;
}


    menu.innerHTML = html;
}
document.querySelectorAll('.lowongan-card').forEach(card => {
    renderDropdown(card);
});

</script>
@endpush
