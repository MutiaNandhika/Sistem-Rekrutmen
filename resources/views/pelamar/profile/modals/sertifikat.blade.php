{{-- ================= MODAL SERTIFIKAT ================= --}}
<div class="modal fade" id="modalSertifikat" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            {{-- HEADER --}}
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Tambah Sertifikat</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">

                {{-- EDIT ID --}}
                <input type="hidden" id="certificateEditId">

                {{-- NAMA SERTIFIKAT --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Sertifikat <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="certName"
                           class="form-control"
                           placeholder="Contoh: Sertifikat UI/UX Design">
                </div>

                {{-- ORGANISASI PENERBIT --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Organisasi Penerbit <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="certIssuer"
                           class="form-control"
                           placeholder="Contoh: Google, Dicoding">
                </div>

                {{-- TANGGAL TERBIT --}}
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

                {{-- MASA AKTIF --}}
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
                        <input class="form-check-input"
                               type="checkbox"
                               id="certNoExpire">
                        <label class="form-check-label">
                            Sertifikat ini tidak memiliki batas masa aktif
                        </label>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Informasi Tambahan (Opsional)
                    </label>
                    <textarea id="certDesc"
                              class="form-control"
                              rows="3"
                              maxlength="2000"
                              placeholder="Contoh: Sertifikat tingkat lanjutan"></textarea>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0">
                <button class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <button class="btn btn-primary"
                        onclick="addCertificate()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>

            </div>

        </div>
    </div>
</div>
