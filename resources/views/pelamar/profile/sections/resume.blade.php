{{-- ================= RESUME ================= --}}
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
        <a href="{{ asset('storage/' . $user->pelamarResume->file) }}"
        target="_blank"
        class="text-primary fw-semibold">
            <i class="bi bi-file-earmark-pdf me-1"></i>
            Lihat Resume
        </a>
    @else
        Belum ada resume diunggah
    @endif

    </div>

    <hr>
</div>
