{{-- ================= PENGALAMAN ORGANISASI & RELAWAN ================= --}}
<div class="cv-section mb-5">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold text-uppercase mb-0">
            Pengalaman Organisasi & Relawan
        </h6>

        <button class="btn btn-link text-primary fw-semibold p-0"
                data-bs-toggle="modal"
                data-bs-target="#modalOrganisasi">
            + Tambahkan
        </button>
    </div>

    <div id="organisasiList">

    @if ($user->pelamarOrganizations->count())
        @foreach ($user->pelamarOrganizations as $org)
            <div class="mb-3">
                <div class="fw-semibold">{{ $org->name }}</div>
                <div class="text-muted small">
                    {{ $org->role }} • {{ $org->period }}
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

</div>
</div>