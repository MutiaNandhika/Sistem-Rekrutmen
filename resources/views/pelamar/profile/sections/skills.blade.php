{{-- ================= SKILLS ================= --}}
<div class="cv-section mb-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold text-uppercase mb-0">Skills</h6>

        <button class="btn btn-link text-primary fw-semibold p-0"
                data-bs-toggle="modal"
                data-bs-target="#modalSkills">
            + Tambahkan
        </button>
    </div>

    <div id="skillsList" class="skills-wrapper">

    @if ($user->pelamarSkills->count())
        @foreach ($user->pelamarSkills as $skill)
            <span class="skill-chip readonly">
                {{ $skill->name }}
            </span>
        @endforeach
    @else
        <span class="skill-chip readonly">
            Belum ada skill
        </span>
    @endif

    </div>


    <hr>
</div>