{{-- Resume --}}
<div class="cv-section mb-5">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold text-uppercase mb-0">Resume</h6>

        <button class="btn btn-link text-primary fw-semibold p-0"
                data-bs-toggle="modal"
                data-bs-target="#modalResume">
            + Tambahkan
        </button>
    </div>

    <p class="text-muted small mb-2">
        Sebanyak 77,4% perusahaan menilai resume sebagai komponen krusial.
    </p>

    {{-- OUTPUT FILE --}}
    <div id="resumeOutput" class="small text-muted">

    @if ($user->pelamarResume)
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ asset('storage/' . $user->pelamarResume->file_path) }}"
            target="_blank"
            class="text-primary fw-semibold"
            id="resumeLink">
                <i class="bi bi-file-earmark-pdf me-1"></i>
                {{ $user->pelamarResume->file_name }}
            </a>

            <button class="btn btn-sm btn-light text-danger"
                    onclick="deleteResume()">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    @else
        <span id="resumeEmpty">Belum ada resume diunggah</span>
    @endif

    </div>

    <hr>
</div>
