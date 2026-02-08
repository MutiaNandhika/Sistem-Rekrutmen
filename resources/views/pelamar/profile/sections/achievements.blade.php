<div class="cv-section">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold text-uppercase mb-0">Penghargaan</h6>

        <button class="btn btn-link text-primary fw-semibold p-0"
                data-bs-toggle="modal"
                data-bs-target="#modalPenghargaan">
            + Tambahkan
        </button>
    </div>

    <div id="penghargaanList">

        @if ($user->pelamarAchievements->count())
            @foreach ($user->pelamarAchievements as $award)

<div class="education-item d-flex justify-content-between align-items-start mb-3"
     id="achievement-{{ $award->id }}">

    {{-- INFO --}}
    <div>
        <h6 class="fw-bold mb-1">{{ $award->judul }}</h6>
        <div class="text-muted small">
            {{ $award->penyelenggara }} • {{ $award->tahun }}
        </div>

        @if ($award->deskripsi)
            <p class="text-muted small mb-0">
                {{ $award->deskripsi }}
            </p>
        @endif

        @if ($award->file_bukti)
            <a href="{{ asset('storage/'.$award->file_bukti) }}"
            target="_blank"
            class="small fw-semibold text-primary">
                <i class="bi bi-paperclip"></i> Lihat File
            </a>
        @endif

    </div>

    {{-- ACTION --}}
    <div class="dropdown">
        <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
            <i class="bi bi-three-dots"></i>
        </button>

        <ul class="dropdown-menu">
            <li>
                <button class="dropdown-item"
                        onclick="editAchievement({{ $award->id }}, @js($award))"
                        data-bs-toggle="modal"
                        data-bs-target="#modalPenghargaan">
                    <i class="bi bi-pencil me-2"></i>Edit
                </button>
            </li>
            <li>
                <button class="dropdown-item text-danger"
                        onclick="deleteAchievement({{ $award->id }})">
                    <i class="bi bi-trash me-2"></i>Hapus
                </button>
            </li>
        </ul>
    </div>

</div>

            @endforeach
        @else
            <p class="text-muted small">
                Tambahkan penghargaan yang pernah kamu raih.
            </p>
        @endif

    </div>

    <hr>
</div>
