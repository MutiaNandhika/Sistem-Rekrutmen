{{-- Tentang Saya --}}

    <div class="cv-section mb-5">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="fw-bold text-uppercase mb-0">Tentang Saya</h6>

            <button
                class="btn btn-link text-primary fw-semibold p-0"
                data-bs-toggle="modal"
                data-bs-target="#modalTentangSaya">
                + Tambahkan
            </button>
        </div>

        <p id="tentangSayaOutput" class="text-muted small mb-3">
            {{ $user->pelamarProfile->tentang_saya
                ?? 'Jelaskan secara singkat kelebihanmu sehingga perusahaan yakin untuk merekrutmu.' }}
        </p>

        <hr>
    </div>