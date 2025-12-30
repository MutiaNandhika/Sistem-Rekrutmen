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

        @php
        $bulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        @endphp

        @if ($user->pelamarEducations->count())
            @foreach ($user->pelamarEducations as $edu)

                <div class="education-item d-flex justify-content-between align-items-start mb-3"
     id="education-{{ $edu->id }}">

    {{-- INFO --}}
    <div>
        <h6 class="fw-bold mb-1">{{ $edu->nama_sekolah }}</h6>
        <div class="text-muted small">{{ $edu->bidang_studi }}</div>
        <div class="text-muted small">
            @if ($edu->mulai_bulan)
                {{ $bulan[$edu->mulai_bulan] ?? '' }}
            @endif
            {{ $edu->mulai_tahun }}

            –

            @if ($edu->selesai_bulan)
                {{ $bulan[$edu->selesai_bulan] ?? '' }}
            @endif
            {{ $edu->selesai_tahun }}
        </div>


        @if ($edu->informasi_tambahan)
            <p class="text-muted small mb-0">
                {{ $edu->informasi_tambahan }}
            </p>
        @endif
    </div>

    {{-- ACTION --}}
    <div class="dropdown">
        <button class="btn btn-sm btn-light"
                data-bs-toggle="dropdown">
            <i class="bi bi-three-dots"></i>
        </button>

        <ul class="dropdown-menu">
            <li>
                <button class="dropdown-item"
                    onclick="editEducation({{ $edu->id }}, @js($edu))"
                    data-bs-toggle="modal"
                    data-bs-target="#modalPendidikan">
                    <i class="bi bi-pencil me-2"></i>Edit
                </button>
            </li>
            <li>
                <button class="dropdown-item text-danger"
                    onclick="deleteEducation({{ $edu->id }})">
                    <i class="bi bi-trash me-2"></i>Hapus
                </button>
            </li>
        </ul>
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
