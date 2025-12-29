{{-- ================= PENGHARGAAN ================= --}}
<div class="cv-section mb-5">

    <div class="d-flex justify-content-between align-items-center mb-2">
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
            <div class="mb-3">
                <div class="fw-semibold">{{ $award->title }}</div>
                <div class="text-muted small">
                    {{ $award->role }} • {{ $award->year }}
                </div>
            </div>
        @endforeach
    @else
        <p class="text-muted small">
            Beritahu prestasimu dengan menambahkan penghargaan di sini.
        </p>
    @endif

    </div>
    <hr>
</div>