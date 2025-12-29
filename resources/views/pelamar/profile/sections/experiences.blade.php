{{-- ================= PENGALAMAN KERJA ================= --}}
<div class="cv-section mb-5">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold text-uppercase mb-0">Pengalaman Kerja</h6>

        <button
            class="btn btn-link text-primary fw-semibold p-0"
            data-bs-toggle="modal"
            data-bs-target="#modalPengalamanKerja">
            + Tambahkan
        </button>
    </div>

    {{-- TIMELINE LIST --}}
<div id="pengalamanList">

@if ($user->pelamarExperiences->count())
    @foreach ($user->pelamarExperiences as $exp)
        <div class="experience-item d-flex gap-3 mb-4">

            <div class="timeline-dot"></div>

            <div class="flex-grow-1">
                <h6 class="fw-bold mb-1">
                    {{ $exp->position }}
                </h6>

                <div class="text-muted small mb-1">
                    {{ $exp->company }}
                    • {{ $exp->start_date }} – {{ $exp->end_date ?? 'Sekarang' }}
                </div>

                <p class="text-muted small mb-0">
                    {{ $exp->description }}
                </p>
            </div>

        </div>
    @endforeach
@else
    <p class="text-muted small">
        Ceritakan pengalaman kerja yang paling relevan dan bisa menarik perhatian HRD
    </p>
@endif

</div>


    <hr>
</div>