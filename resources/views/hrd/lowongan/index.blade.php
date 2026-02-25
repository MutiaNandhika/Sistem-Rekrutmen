@extends('layouts.hrd')

@section('title', 'Daftar Lowongan Kerja')

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
                <a class="nav-link {{ $statusFilter === 'all' ? 'active' : '' }}" href="#" data-filter="all">
                    Semua Loker
                    <span class="badge" data-count="total">
                        {{ $tabCounts['total'] ?? 0 }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $statusFilter === 'aktif' ? 'active' : '' }}" href="#" data-filter="aktif">
                    Aktif
                    <span class="badge" data-count="aktif">
                        {{ $tabCounts['aktif'] ?? 0 }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $statusFilter === 'nonaktif' ? 'active' : '' }}" href="#" data-filter="nonaktif">
                    Nonaktif
                    <span class="badge" data-count="nonaktif">
                        {{ $tabCounts['nonaktif'] ?? 0 }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $statusFilter === 'arsip' ? 'active' : '' }}" href="#" data-filter="arsip">
                    Arsip
                    <span class="badge" data-count="arsip">
                        {{ $tabCounts['arsip'] ?? 0 }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $statusFilter === 'draft' ? 'active' : '' }}" href="#" data-filter="draft">
                    Draft
                    <span class="badge" data-count="draft">
                        {{ $tabCounts['draft'] ?? 0 }}
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

<div class="d-flex justify-content-between align-items-center mb-3">

    {{-- SEARCH --}}
    <form method="GET" class="d-flex gap-2">

        <input type="text"
               name="search"
               class="form-control"
               placeholder="Cari lowongan, lokasi, atau PIC..."
               value="{{ request('search') }}">

        {{-- pertahankan filter pic --}}
        @if(request('pic'))
            <input type="hidden" name="pic" value="{{ request('pic') }}">
        @endif

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-search"></i>
        </button>

        @if(request('search'))
            <a href="{{ route('hrd.lowongan.index') }}"
               class="btn btn-outline-secondary">
                Reset
            </a>
        @endif

    </form>

    {{-- FILTER PIC --}}
    <form method="GET">
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        <select name="pic"
                class="form-select w-auto"
                onchange="this.form.submit()">
            <option value="">Semua PIC (HRD)</option>
            @foreach ($hrds as $hrd)
                <option value="{{ $hrd->id }}"
                    {{ request('pic') == $hrd->id ? 'selected' : '' }}>
                    {{ $hrd->name }}
                </option>
            @endforeach
        </select>
    </form>

</div>

{{-- LIST LOWONGAN --}}
<div class="lowongan-list">
    @include('hrd.lowongan.partials.list')
</div>
@endsection

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {

let controller = null;
const searchInput = document.querySelector('input[name="search"]');
const picSelect = document.querySelector('select[name="pic"]');
let debounceTimer;

/* ================= LOAD LOWONGAN AJAX ================= */
function loadLowongan(url = null) {

    const search = searchInput?.value || '';
    const pic = picSelect?.value || '';
    const activeTab = document.querySelector('.lowongan-tabs .nav-link.active');
    const status = activeTab ? activeTab.dataset.filter : 'all';

    let fetchUrl = url
        ? url
        : `/hrd/lowongan?search=${encodeURIComponent(search)}&pic=${encodeURIComponent(pic)}&status=${encodeURIComponent(status)}`;

    if (controller) {
        controller.abort();
    }

    controller = new AbortController();

    fetch(fetchUrl, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        cache: "no-store",
        signal: controller.signal
    })
    .then(res => res.json())
    .then(data => {

        const container = document.querySelector('.lowongan-list');
        if (!container) return;

        // Render HTML content
        container.innerHTML = data.html;

        container.querySelectorAll('.lowongan-card')
            .forEach(card => renderDropdown(card));

        // Update accurate tab badges from complete server totals
        if (data.counts) {
            updateTabBadges(data.counts);
        }
    })
    .catch(err => {
        if (err.name === 'AbortError') return;
        console.error("ERROR DETAIL:", err);
        alert('Gagal memuat data');
    });
}

function updateTabBadges(counts) {
    const totalEl = document.querySelector('[data-count="total"]');
    const aktifEl = document.querySelector('[data-count="aktif"]');
    const nonaktifEl = document.querySelector('[data-count="nonaktif"]');
    const draftEl = document.querySelector('[data-count="draft"]');
    const arsipEl = document.querySelector('[data-count="arsip"]');

    if (totalEl) totalEl.textContent = counts.total;
    if (aktifEl) aktifEl.textContent = counts.aktif;
    if (nonaktifEl) nonaktifEl.textContent = counts.nonaktif;
    if (draftEl) draftEl.textContent = counts.draft;
    if (arsipEl) arsipEl.textContent = counts.arsip;
}

/* ================= SEARCH DEBOUNCE ================= */
searchInput?.addEventListener('keyup', () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        loadLowongan();
    }, 400);
});

/* ================= FILTER PIC ================= */
picSelect?.addEventListener('change', () => {
    loadLowongan();
});

/* ================= AJAX PAGINATION ================= */
document.addEventListener('click', function(e) {

    const link = e.target.closest('.pagination a');

    if (link) {
        e.preventDefault();
        loadLowongan(link.href);
    }

});

/* ================= DELETE ================= */
function deleteLowongan(id, btn) {

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
            return response.json().then(data => {
                if (!response.ok || data.success === false) {
                    throw new Error(data.message || 'Gagal menghapus data');
                }
                return data;
            });
        })

        .then(() => {

            const card = btn.closest('.lowongan-card');
            if (card) {
                card.remove();
                updateCounters();
            }

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

        // 1. Update Active State UI
        document.querySelectorAll('.lowongan-tabs .nav-link')
            .forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        // 2. Fetch data from server based on the active tab's status
        loadLowongan();
    });
});

/* ================= SORT ================= */
const sortBtn = document.getElementById('sortButton');

if (sortBtn) {
    sortBtn.addEventListener('click', function () {

        const list = document.querySelector('.lowongan-list');
        if (!list) return;

        const cards = [...list.querySelectorAll('.lowongan-card')];
        const order = this.dataset.order;

        cards.sort((a,b) =>
            order === 'desc'
                ? new Date(b.dataset.updated) - new Date(a.dataset.updated)
                : new Date(a.dataset.updated) - new Date(b.dataset.updated)
        );

        cards.forEach(card => list.appendChild(card));
        this.dataset.order = order === 'desc' ? 'asc' : 'desc';
    });
}

/* ================= COUNTER ================= */
// Deprecated. We now use updateTabBadges(counts) from Backend API response.
function updateCounters() {
    // Left empty specifically because we don't want to count only visible DOM elements anymore.
    // The server returns absolute counts, which is handled in loadLowongan's updateTabBadges().
}

/* ================= DROPDOWN ACTION ================= */

function renderDropdown(card) {
    const status = card.dataset.status;
    const expired = card.dataset.expired === 'true';
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

    if (status === 'nonaktif' && !expired) {
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

    if (status === 'nonaktif' && expired) {
        html = `
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
            <button type="button" class="dropdown-item text-success"
                    onclick="restoreLowongan(this)">
                Kembalikan ke Draft
            </button>
        </li>
        `;
    }

    menu.innerHTML = html;
}

/* ================= Perubahan Status ================= */
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
        console.log("STATUS:", res.status);
        if (!res.ok) throw new Error('Gagal update status');
        return res.json();
    })
    .then(data => {

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

/* ================= GLOBAL EXPORT ================= */
window.deleteLowongan = deleteLowongan;
window.publishLowongan = publishLowongan;
window.deactivateLowongan = deactivateLowongan;
window.activateLowongan = activateLowongan;
window.archiveLowongan = archiveLowongan;
window.restoreLowongan = restoreLowongan;

})
</script>
@endpush