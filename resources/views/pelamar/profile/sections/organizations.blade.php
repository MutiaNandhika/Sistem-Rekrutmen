{{-- ================= PENGALAMAN ORGANISASI & RELAWAN ================= --}}
<div class="cv-section mb-5">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold text-uppercase mb-0">
            Pengalaman Organisasi & Relawan
        </h6>

        <button class="btn btn-link p-0"
                data-bs-toggle="modal"
                data-bs-target="#modalOrganisasi">
            + Tambahkan
        </button>
    </div>

    <div id="organisasiList">

        @php
        $bulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        @endphp

        @if ($user->pelamarOrganizations->count())
            @foreach ($user->pelamarOrganizations as $org)

            <div class="education-item d-flex justify-content-between align-items-start mb-3"
                 id="organization-{{ $org->id }}">

                <div>
                    <h6 class="fw-bold mb-1">{{ $org->nama_organisasi }}</h6>

                    <div class="text-muted small">
                        {{ $org->posisi }} •
                        {{ $bulan[$org->mulai_bulan] }} {{ $org->mulai_tahun }}
                        –
                        @if ($org->masih_aktif)
                            Sekarang
                        @else
                            {{ $bulan[$org->selesai_bulan] }} {{ $org->selesai_tahun }}
                        @endif
                    </div>

                    @if ($org->informasi_tambahan)
                        <p class="text-muted small mb-0">
                            {{ $org->informasi_tambahan }}
                        </p>
                    @endif
                </div>

                <div class="dropdown">
                    <button class="btn btn-sm btn-light"
                            data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots"></i>
                    </button>

                    <ul class="dropdown-menu">
                        <li>
                            <button class="dropdown-item"
                                onclick="editOrganization({{ $org->id }}, @js($org))"
                                data-bs-toggle="modal"
                                data-bs-target="#modalOrganisasi">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item text-danger"
                                onclick="deleteOrganization({{ $org->id }})">
                                <i class="bi bi-trash me-2"></i>Hapus
                            </button>
                        </li>
                    </ul>
                </div>

            </div>

            @endforeach
        @else
            <p class="text-muted small">
                Adakah kegiatan ekstrakurikuler atau relawan yang ingin kamu tampilkan?
            </p>
        @endif

    </div>

    <hr>
</div>
