<div class="modal fade" id="modalSertifikat" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Tambah Sertifikat</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="certificateEditId">

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Sertifikat <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="certName"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Organisasi Penerbit <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="certIssuer"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Tanggal Diterbitkan <span class="text-danger">*</span>
                    </label>

                    <div class="row g-2">
                        <div class="col-6">
                            <select id="certIssueMonth" class="form-select">
                                <option value="">Bulan</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-6">
                            <select id="certIssueYear" class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Batas Masa Aktif
                    </label>

                    <div class="row g-2">
                        <div class="col-6">
                            <select id="certExpireMonth" class="form-select">
                                <option value="">Bulan</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-6">
                            <select id="certExpireYear" class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-check mt-2">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="certNoExpire">
                        <label class="form-check-label">
                            Sertifikat ini tidak memiliki batas masa aktif
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Informasi Tambahan (Opsional)
                    </label>
                    <textarea
                        id="certDesc"
                        class="form-control"
                        rows="3"
                        maxlength="2000"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        File Bukti Sertifikat <span class="text-danger">*</span>
                    </label>
                    <input
                        type="file"
                        id="certFile"
                        class="form-control"
                        accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">
                        Sertifikat (PDF / JPG / PNG)
                    </small>
                </div>

                <div class="mb-3 d-none" id="certFilePreview">
                    <label class="form-label fw-semibold">File Saat Ini</label>
                    <div>
                        <a
                            href="#"
                            target="_blank"
                            id="certFileLink"
                            class="fw-semibold text-primary">
                            <i class="bi bi-paperclip me-1"></i>Lihat File Sertifikat
                        </a>
                    </div>
                    <small class="text-muted">
                        Upload file baru jika ingin mengganti
                    </small>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button
                    class="btn btn-light"
                    data-bs-dismiss="modal">
                    Batal
                </button>

                <button
                    class="btn btn-primary"
                    onclick="addCertificate()"
                    data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>

@php
    $certificatesData = $user->pelamarCertificates->map(function($cert) {
        return [
            'id' => $cert->id,
            'nama_sertifikat' => $cert->nama_sertifikat,
            'organisasi_penerbit' => $cert->organisasi_penerbit,
            'bulan_terbit' => $cert->bulan_terbit,
            'tahun_terbit' => $cert->tahun_terbit,
            'tanpa_expired' => $cert->tanpa_expired,
            'bulan_expired' => $cert->bulan_expired,
            'tahun_expired' => $cert->tahun_expired,
            'informasi_tambahan' => $cert->informasi_tambahan,
            'file_url' => $cert->file_bukti
                ? \Storage::disk('s3')->url($cert->file_bukti)
                : null,
        ];
    });
@endphp

<script>
    const certificates = @json($certificatesData);
</script>