{{-- ================= SERTIFIKAT ================= --}}
<div class="cv-section mb-5">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold text-uppercase mb-0">Sertifikat</h6>

        <button class="btn btn-link text-primary fw-semibold p-0"
                data-bs-toggle="modal"
                data-bs-target="#modalSertifikat">
            + Tambahkan
        </button>
    </div>

    {{-- LIST SERTIFIKAT --}}
    <div id="sertifikatList">

    @if ($user->pelamarCertificates->count())
        @foreach ($user->pelamarCertificates as $cert)
            <div class="mb-3">
                <div class="fw-semibold">{{ $cert->name }}</div>
                <div class="text-muted small">
                    {{ $cert->issuer }} • {{ $cert->year }}
                </div>
            </div>
        @endforeach
    @else
        <p class="text-muted small">
            Beritahu prestasimu dengan menambahkan sertifikat di sini.
        </p>
    @endif

    </div>
    <hr>
</div>