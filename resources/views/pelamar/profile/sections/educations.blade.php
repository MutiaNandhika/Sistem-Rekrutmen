{{-- ================= PENDIDIKAN ================= --}}
<div class="cv-section">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold text-uppercase mb-0">Pendidikan</h6>

        <button class="btn btn-link text-primary fw-semibold p-0"
                data-bs-toggle="modal"
                data-bs-target="#modalPendidikan">
            + Tambahkan
        </button>
    </div>

    <div id="pendidikanList">

        @if ($user->pelamarEducations->count())
            @foreach ($user->pelamarEducations as $edu)

                <div class="education-item d-flex justify-content-between align-items-start mb-3">

                    {{-- INFO --}}
                    <div>
                        <h6 class="fw-bold mb-1">{{ $edu->school }}</h6>
                        <div class="text-muted small">{{ $edu->major }}</div>
                        <div class="text-muted small">
                            {{ $edu->start_year }} – {{ $edu->end_year }}
                        </div>
                    </div>

                    {{-- ACTION --}}
                    <div class="education-actions position-relative">
                        <button class="btn btn-sm btn-light"
                                onclick="toggleEducationMenu(this)">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>

                        <div class="education-menu shadow">
                            <button onclick="editEducation(this)">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </button>
                            <button class="text-danger"
                                    onclick="deleteEducation(this)">
                                <i class="bi bi-trash me-2"></i>Hapus
                            </button>
                        </div>
                    </div>

                </div>

            @endforeach
        @else
            <p class="text-muted small">
                Tambahkan riwayat pendidikan terakhirmu.
            </p>
        @endif

    </div>

    <hr>
</div>
