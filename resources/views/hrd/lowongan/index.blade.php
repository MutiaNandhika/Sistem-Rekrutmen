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
            <div class="lowongan-header">
                <div>
                    <h6>{{ $lowongan->judul }}</h6>
                    <small class="text-muted">
                        <i class="bi bi-clock"></i>
                        {{ \Carbon\Carbon::parse($lowongan->updated_at ?? '2025-01-01')->translatedFormat('d M Y') }}
                    </small>
                </div>

                <span class="status-badge {{ $lowongan->status }}"
                    data-status="{{ $lowongan->status }}"
                    onclick="toggleStatus(this)">
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

                <button
                    class="btn btn-delete"
                    onclick="deleteLowongan(this)"
                >
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
                filter === 'all' || card.dataset.status === filter
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

    let total = cards.length;
    let aktif = 0, nonaktif = 0, draft = 0;

    cards.forEach(card => {
        const status = card.dataset.status;
        if (status === 'aktif') aktif++;
        if (status === 'nonaktif') nonaktif++;
        if (status === 'draft') draft++;
    });

    document.querySelector('[data-count="total"]').textContent = total;
    document.querySelector('[data-count="aktif"]').textContent = aktif;
    document.querySelector('[data-count="nonaktif"]').textContent = nonaktif;
    document.querySelector('[data-count="draft"]').textContent = draft;
}

/* ================= TOGGLE ================= */
function toggleStatus(el) {
    const current = el.dataset.status;
    const next = current === 'aktif' ? 'nonaktif' : 'aktif';

    if (!confirm(`Apakah anda yakin ingin ${next === 'aktif' ? 'mengaktifkan' : 'menonaktifkan'} lowongan ini?`)) return;

    el.dataset.status = next;
    el.textContent = next.charAt(0).toUpperCase() + next.slice(1);
    el.classList.remove('aktif', 'nonaktif');
    el.classList.add(next);

    const card = el.closest('.lowongan-card');
    card.dataset.status = next;
    card.classList.toggle('active', next === 'aktif');

    updateCounters();

    // reapply active filter
    document.querySelector('.lowongan-tabs .nav-link.active')?.click();
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
</script>
@endpush
