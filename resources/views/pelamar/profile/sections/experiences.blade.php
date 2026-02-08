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
<div class="experience-item d-flex justify-content-between align-items-start mb-3"
     id="experience-{{ $exp->id }}">

    {{-- INFO --}}
    <div class="d-flex gap-3">

        {{-- CONTENT --}}
        <div>
            <h6 class="fw-bold mb-1">{{ $exp->posisi }}</h6>

            <div class="text-muted small mb-1">
                {{ $exp->perusahaan }}
                • {{ $exp->tanggal_mulai->format('M Y') }}
                –
                {{ $exp->tanggal_selesai
                    ? $exp->tanggal_selesai->format('M Y')
                    : 'Sekarang' }}
            </div>

            @if ($exp->deskripsi)
                <p class="text-muted small mb-0">
                    {{ $exp->deskripsi }}
                </p>
            @endif

            @if ($exp->file_bukti)
                <a href="{{ asset('storage/'.$exp->file_bukti) }}"
                target="_blank"
                class="small text-primary fw-semibold">
                    <i class="bi bi-paperclip"></i> Lihat File
                </a>
            @endif

        </div>
    </div>

    {{-- ACTION --}}
    <div class="dropdown">
        <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
            <i class="bi bi-three-dots"></i>
        </button>

        <ul class="dropdown-menu">
            <li>
                <button class="dropdown-item"
                    onclick="editExperience({{ $exp->id }}, @js($exp))"
                    data-bs-toggle="modal"
                    data-bs-target="#modalPengalamanKerja">
                    <i class="bi bi-pencil me-2"></i>Edit
                </button>
            </li>
            <li>
                <button class="dropdown-item text-danger"
                        onclick="deleteExperience({{ $exp->id }})">
                    <i class="bi bi-trash me-2"></i>Hapus
                </button>
            </li>
        </ul>
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