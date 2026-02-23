@php use Illuminate\Support\Facades\Storage; @endphp
{{-- Sertifikat --}}
<div class="cv-section mb-5">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="fw-bold text-uppercase mb-0">Sertifikat</h6>

        <button
            class="btn btn-link text-primary fw-semibold p-0"
            data-bs-toggle="modal"
            data-bs-target="#modalSertifikat">
            + Tambahkan
        </button>
    </div>

    <div id="sertifikatList">

        @php
            $bulan = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
            ];
        @endphp

        @if ($user->pelamarCertificates->count())
            @foreach ($user->pelamarCertificates as $cert)

                @php
                    $bulanTerbit  = $bulan[$cert->bulan_terbit] ?? null;
                    $bulanExpired = $bulan[$cert->bulan_expired] ?? null;
                @endphp

                <div
                    class="education-item d-flex justify-content-between align-items-start mb-3"
                    id="certificate-{{ $cert->id }}">

                    <div>
                        <h6 class="fw-bold mb-1">
                            {{ $cert->nama_sertifikat }}
                        </h6>

                        {{-- ================= TANGGAL ================= --}}
                        <div class="text-muted small">

                            {{-- Tanggal Terbit --}}
                            @if($bulanTerbit)
                                {{ $bulanTerbit }} {{ $cert->tahun_terbit }}
                            @else
                                {{ $cert->tahun_terbit }}
                            @endif

                            {{-- Expired --}}
                            @if ($cert->tanpa_expired)
                                • Tidak kedaluwarsa
                            @elseif ($bulanExpired && $cert->tahun_expired)
                                – {{ $bulanExpired }} {{ $cert->tahun_expired }}
                            @endif

                        </div>

                        {{-- Informasi tambahan --}}
                        @if ($cert->informasi_tambahan)
                            <p class="text-muted small mb-0">
                                {{ $cert->informasi_tambahan }}
                            </p>
                        @endif

                        {{-- File Bukti --}}
                        @if ($cert->file_bukti)
                            <div class="mt-1">
                                <a
                                    href="{{ Storage::disk('s3')->url($cert->file_bukti) }}"
                                    target="_blank"
                                    class="text-primary small fw-semibold">
                                    <i class="bi bi-paperclip me-1"></i>
                                    Lihat File
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Dropdown --}}
                    <div class="dropdown">
                        <button
                            class="btn btn-sm btn-light"
                            data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots"></i>
                        </button>

                        <ul class="dropdown-menu">
                            <li>
                                <button
                                    class="dropdown-item"
                                    onclick="editCertificate({{ $cert->id }}, @js($cert))"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalSertifikat">
                                    <i class="bi bi-pencil me-2"></i>Edit
                                </button>
                            </li>
                            <li>
                                <button
                                    class="dropdown-item text-danger"
                                    onclick="deleteCertificate({{ $cert->id }})">
                                    <i class="bi bi-trash me-2"></i>Hapus
                                </button>
                            </li>
                        </ul>
                    </div>

                </div>

            @endforeach
        @else
            <p class="text-muted small">
                Tambahkan sertifikat yang kamu miliki.
            </p>
        @endif

    </div>

    <hr>
</div>
