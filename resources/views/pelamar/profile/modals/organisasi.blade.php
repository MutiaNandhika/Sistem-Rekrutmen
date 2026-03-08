<div class="modal fade" id="modalOrganisasi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0">
            <h6 class="modal-title fw-bold" id="organizationModalTitle">
                Tambah Organisasi
            </h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="orgEditId">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Organisasi <span class="text-danger">*</span></label>
                    <input id="orgName" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Posisi <span class="text-danger">*</span></label>
                    <input id="orgRole" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Mulai <span class="text-danger">*</span></label>
                    <div class="row g-2">
                        <div class="col-6">
                            <select id="orgStartMonth" class="form-select">
                                <option value="">Bulan</option>
                                @for ($i=1;$i<=12;$i++)
                                    <option value="{{ $i }}">
                                        {{ DateTime::createFromFormat('!m',$i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-6">
                            <select id="orgStartYear" class="form-select">
                                <option value="">Tahun</option>
                                @for ($y=date('Y');$y>=1980;$y--)
                                    <option>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Selesai</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <select id="orgEndMonth" class="form-select">
                                <option value="">Bulan</option>
                                @for ($i=1;$i<=12;$i++)
                                    <option value="{{ $i }}">
                                        {{ DateTime::createFromFormat('!m',$i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-6">
                            <select id="orgEndYear" class="form-select">
                                <option value="">Tahun</option>
                                @for ($y=date('Y');$y>=1980;$y--)
                                    <option>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-check mt-2">
                        <input id="orgOngoing" type="checkbox" class="form-check-input">
                        <label class="form-check-label">
                            Saya masih aktif
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Informasi Tambahan</label>
                    <textarea id="orgDesc" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        File Bukti Organisasi <span class="text-danger">*</span>
                    </label>
                    <input type="file"
                        id="orgFile"
                        class="form-control"
                        accept=".pdf,.jpg,.jpeg,.png">
                    <div class="small text-muted mt-1">
                        Surat tugas / sertifikat / dokumentasi (PDF / JPG / PNG)
                    </div>
                </div>

                <div class="mb-3 d-none" id="orgFilePreview">
                    <label class="form-label fw-semibold">File Saat Ini</label>

                    <div>
                        <a href="#"
                        target="_blank"
                        class="fw-semibold text-primary"
                        id="orgFileLink">
                            <i class="bi bi-paperclip"></i> Lihat File
                        </a>
                    </div>

                    <small class="text-muted">
                        Upload file baru jika ingin mengganti
                    </small>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary"
                        onclick="saveOrg()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>

@php
    $organizationsData = $user->pelamarOrganizations->map(function($org) {
        return [
            'id' => $org->id,
            'nama_organisasi' => $org->nama_organisasi,
            'posisi' => $org->posisi,
            'mulai_bulan' => $org->mulai_bulan,
            'mulai_tahun' => $org->mulai_tahun,
            'selesai_bulan' => $org->selesai_bulan,
            'selesai_tahun' => $org->selesai_tahun,
            'masih_aktif' => $org->masih_aktif,
            'informasi_tambahan' => $org->informasi_tambahan,
            'file_url' => $org->file_bukti
                ? \Storage::disk('s3')->url($org->file_bukti)
                : null,
        ];
    });
@endphp

<script>
    const organizations = @json($organizationsData);
</script>