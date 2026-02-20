@forelse ($lowongans as $lowongan)
    <div class="lowongan-card {{ $lowongan->status === 'aktif' ? 'active' : '' }}"
     data-id="{{ $lowongan->id }}"
     data-status="{{ $lowongan->status }}"
     data-updated="{{ optional($lowongan->updated_at)->format('c') }}"
     data-expired="{{ $lowongan->isExpired() ? 'true' : 'false' }}">

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
                {{ $lowongan->tanggal_selesai?->translatedFormat('d M Y') ?? '-' }}
            </strong>
        </small>

        {{-- INFO PIC --}}
        <small class="text-muted">
            PIC:
            <span class="badge 
                    {{ $lowongan->
                hrd_id === $userId ? 'bg-success' : 'bg-secondary' }}">
                    {{ $lowongan->hrd_id === $userId 
                        ? 'Saya' 
                        : optional($lowongan->hrd)->name ?? '-' }}
            </span>
        </small>

        {{-- ACTIONS --}}
        <div class="lowongan-actions">

            <div class="left-actions">
                <a href="{{ route('hrd.lowongan.show',$lowongan->
                    id) }}"
                class="btn-dashboard orange sm">
                    Detail Lowongan
                </a>
                    @if ($lowongan->hrd_id === auth()->id())
                <a href="{{ route('hrd.kandidat.index',$lowongan->
                    id) }}"
                   class="btn-dashboard blue sm">
                    Kelola Kandidat
                </a>
                @endif
            </div>

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

                <button class="action-btn delete"
                        onclick="deleteLowongan({{ $lowongan->
                    id }}, this)"
                        title="Hapus Lowongan">
                    <i class="bi bi-trash">
                    </i>
                </button>
                
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

@if ($lowongans->hasPages())
    <div class="mt-4">
        {{ $lowongans->withQueryString()->links() }}
    </div>
@endif