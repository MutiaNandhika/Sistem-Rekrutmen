@extends('layouts.hrd')

@section('title', 'Daftar Lowongan Kerja')

@php
    $total = $lowongans->where('status', '!=', 'arsip')->count();
    $aktif = $lowongans->where('status', 'aktif')->count();
    $nonaktif = $lowongans->where('status', 'nonaktif')->count();
    $draft = $lowongans->where('status', 'draft')->count();
    $arsip = $lowongans->where('status', 'arsip')->count();
@endphp

@section('content')

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">
        Daftar Lowongan Kerja
    </h4>
    <a href="{{ route('hrd.lowongan.create') }}"
       class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg">
        </i>
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
                    <span class="badge" data-count="total">
                        {{ $total }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-filter="aktif">
                    Aktif
                    <span class="badge" data-count="aktif">
                        {{ $aktif }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-filter="nonaktif">
                    Nonaktif
                    <span class="badge" data-count="nonaktif">
                        {{ $nonaktif }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-filter="arsip">
                    Arsip
                    <span class="badge" data-count="arsip">
                        {{ $arsip }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-filter="draft">
                    Draft
                    <span class="badge" data-count="draft">
                        {{ $draft }}
                    </span>
                </a>
            </li>
        </ul>
        <button id="sortButton" class="btn btn-light border" data-order="desc">
            <i class="bi bi-arrow-down-up">
            </i>
            Urutkan: Terbaru
        </button>
    </div>
</div>
<form method="GET" class="mb-3">
    <select name="pic"
            class="form-select w-auto"
            onchange="this.form.submit()">
        <option value="">
            Semua PIC (HRD)
        </option>
        @foreach ($hrds as $hrd)
        <option value="{{ $hrd->
            id }}"
                {{ request('pic') == $hrd->id ? 'selected' : '' }}>
                {{ $hrd->name }}
        </option>
        @endforeach
    </select>
</form>
{{-- LIST LOWONGAN --}}
<div class="lowongan-list">
    @forelse ($lowongans as $lowongan)
    <div class="lowongan-card {{ $lowongan->
        status === 'aktif' ? 'active' : '' }}"
     data-id="{{ $lowongan->id }}"
     data-status="{{ $lowongan->status }}"
     data-updated="{{ $lowongan->updated_at }}">

        {{-- HEADER --}}
        <div class="lowongan-header d-flex justify-content-between align-items-start">
            <div>
                <h6>
                    {{ $lowongan->nama_lowongan }}
                </h6>
                <small class="text-muted">
                    <i class="bi bi-clock">
                    </i>
                    {{ $lowongan->updated_at->translatedFormat('d M Y') }}
                </small>
            </div>
            <span class="status-badge {{ $lowongan->
                status }}">
                {{ ucfirst($lowongan->status) }}
            </span>
        </div>
        {{-- META --}}
        <ul class="lowongan-meta">
            <li>
                <i class="bi bi-briefcase">
                </i>
                {{ ucfirst(str_replace('_',' ',$lowongan->tipe_kerja)) }}
            </li>
            <li>
                <i class="bi bi-geo-alt">
                </i>
                {{ $lowongan->lokasi }}
            </li>
        </ul>

{{-- BATAS PENDAFTARAN --}}
<small class="text-muted d-block mt-1">
    <i class="bi bi-calendar-x"></i>
    Ditutup pada:
    <strong>
        {{ \Carbon\Carbon::parse($lowongan->tanggal_selesai)->translatedFormat('d M Y') }}
    </strong>
</small>

        {{-- INFO PIC --}}
        <small class="text-muted">
            PIC:
            <span class="badge 
                    {{ $lowongan->
                hrd_id === $userId ? 'bg-success' : 'bg-secondary' }}">
                    {{ $lowongan->hrd_id === $userId ? 'Saya' : $lowongan->hrd->name }}
            </span>
        </small>
        {{-- ACTIONS --}}
        <div class="lowongan-actions">
            {{-- LEFT --}}
            <div class="left-actions">
                <a href="{{ route('hrd.lowongan.show',$lowongan->
                    id) }}"
                class="btn-dashboard orange sm">
                    Detail Lowongan
                </a>
                {{-- KELOLA (HANYA PIC) --}}
                    @if ($lowongan->hrd_id === auth()->id())
                <a href="{{ route('hrd.kandidat.index',$lowongan->
                    id) }}"
                   class="btn-dashboard blue sm">
                    Kelola Kandidat
                </a>
                @endif
            </div>
            {{-- RIGHT --}}
            <div class="right-actions action-icons">
                @if ($lowongan->hrd_id === auth()->id())
                <a href="{{ route('hrd.lowongan.edit',$lowongan->
                    id) }}"
                   class="action-btn edit"
                   title="Edit Lowongan">
                    <i class="bi bi-pencil">
                    </i>
                </a>
                @else
                <span class="badge bg-info">
                    Read Only
                </span>
                @endif

                {{-- DELETE --}}
                <button class="action-btn delete"
                        onclick="deleteLowongan({{ $lowongan->
                    id }}, this)"
                        title="Hapus Lowongan">
                    <i class="bi bi-trash">
                    </i>
                </button>
                {{-- DROPDOWN --}}
                <div class="dropdown">
                    <button class="action-btn more"
                            data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots">
                        </i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end action-menu">
                    </ul>
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

@push('scripts')
<script>
/* ================= DELETE (REAL DB) ================= */
function deleteLowongan(id, btn) {

    // 🔥 SWEETALERT CONFIRM
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Lowongan yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d'
    }).then((result) => {

        if (!result.isConfirmed) return;

        // 🚀 PROSES DELETE (TETAP SAMA)
        fetch(`/hrd/lowongan/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal menghapus data');
            }
            return response.json();
        })
        .then(() => {

            const card = btn.closest('.lowongan-card');
            if (card) {
                card.remove();
                updateCounters();
            }

            // ✅ POPUP BERHASIL
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Lowongan berhasil dihapus',
                timer: 2000,
                showConfirmButton: false
            });

        })
        .catch(err => {
            console.error(err);

            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan saat menghapus data'
            });
        });

    });
}

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

    cards.sort((a,b) =>
        order === 'desc'
            ? new Date(b.dataset.updated) - new Date(a.dataset.updated)
            : new Date(a.dataset.updated) - new Date(b.dataset.updated)
    );

    cards.forEach(card => list.appendChild(card));
    this.dataset.order = order === 'desc' ? 'asc' : 'desc';
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

/* ================= DROPDOWN ACTION ================= */

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
    <li>
        <button type="button"
                    class="dropdown-item text-success"
                    onclick="restoreLowongan(this)">
            Kembalikan ke Draft
        </button>
    </li>
    `;
}

    menu.innerHTML = html;
}

/* ================= STATUS CHANGE (FRONTEND ONLY) ================= */
function confirmStatusChange({ title, text, onConfirm }) {
    Swal.fire({
        title,
        text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d'
    }).then(result => {
        if (result.isConfirmed) {
            onConfirm();
        }
    });
}

function publishLowongan(btn) {
    confirmStatusChange({
        title: 'Publish lowongan?',
        text: 'Lowongan akan mulai ditampilkan ke pelamar.',
        onConfirm: () => {
            updateStatus(btn.closest('.lowongan-card'), 'aktif');
        }
    });
}

function deactivateLowongan(btn) {
    confirmStatusChange({
        title: 'Nonaktifkan lowongan?',
        text: 'Lowongan ini tidak akan tampil ke pelamar.',
        onConfirm: () => {
            updateStatus(btn.closest('.lowongan-card'), 'nonaktif');
        }
    });
}

function activateLowongan(btn) {
    confirmStatusChange({
        title: 'Aktifkan kembali?',
        text: 'Lowongan akan aktif kembali.',
        onConfirm: () => {
            updateStatus(btn.closest('.lowongan-card'), 'aktif');
        }
    });
}


function archiveLowongan(btn) {
    confirmStatusChange({
        title: 'Arsipkan lowongan?',
        text: 'Lowongan akan dipindahkan ke arsip.',
        onConfirm: () => {
            updateStatus(btn.closest('.lowongan-card'), 'arsip');
        }
    });
}

function restoreLowongan(btn) {
    confirmStatusChange({
        title: 'Kembalikan ke draft?',
        text: 'Lowongan akan kembali ke status draft.',
        onConfirm: () => {
            updateStatus(btn.closest('.lowongan-card'), 'draft');
        }
    });
}

function updateStatus(card, status) {
    if (!card) return;

    const id = card.dataset.id;

    fetch(`/hrd/lowongan/${id}/status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status })
    })
    .then(res => {
        if (!res.ok) throw new Error('Gagal update status');
        return res.json();
    })
    .then(data => {

        // 🔥 UPDATE UI SETELAH DB BERHASIL
        card.dataset.status = data.status;
        card.classList.toggle('active', data.status === 'aktif');

        const badge = card.querySelector('.status-badge');
        if (badge) {
            badge.textContent =
                data.status.charAt(0).toUpperCase() + data.status.slice(1);
            badge.className = `status-badge ${data.status}`;
        }

        renderDropdown(card);
        updateCounters();

        document
            .querySelector('.lowongan-tabs .nav-link.active')
            ?.click();
        
            if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Status Diperbarui',
                text: 'Status lowongan berhasil diubah',
                timer: 1800,
                showConfirmButton: false
            });
        }

    })
    .catch(err => {
    console.error(err);
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Gagal memperbarui status lowongan'
        });
    } else {
        alert('Gagal memperbarui status lowongan');
    }
});

}

/* ================= INIT ================= */
document.querySelectorAll('.lowongan-card').forEach(card => {
    renderDropdown(card);
});
</script>
@endpush