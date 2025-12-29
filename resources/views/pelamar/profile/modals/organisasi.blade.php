{{-- ================= MODAL ORGANISASI & RELAWAN ================= --}}
<div class="modal fade" id="modalOrganisasi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            {{-- HEADER --}}
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">
                    Tambah Pengalaman Organisasi & Relawan
                </h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">

                <input type="hidden" id="orgEditId">

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Organisasi atau Kegiatan <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="orgName"
                           class="form-control"
                           placeholder="Contoh: Himpunan Mahasiswa Informatika">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Posisi <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="orgRole"
                           class="form-control"
                           placeholder="Contoh: Ketua Divisi Acara">
                </div>

                {{-- MULAI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Mulai</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <select id="orgStartMonth" class="form-select">
                                <option value="">Bulan</option>
                                <option>Januari</option>
                                <option>Februari</option>
                                <option>Maret</option>
                                <option>April</option>
                                <option>Mei</option>
                                <option>Juni</option>
                                <option>Juli</option>
                                <option>Agustus</option>
                                <option>September</option>
                                <option>Oktober</option>
                                <option>November</option>
                                <option>Desember</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <select id="orgStartYear" class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                {{-- SELESAI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Selesai</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <select id="orgEndMonth" class="form-select">
                                <option value="">Bulan</option>
                                <option>Januari</option>
                                <option>Februari</option>
                                <option>Maret</option>
                                <option>April</option>
                                <option>Mei</option>
                                <option>Juni</option>
                                <option>Juli</option>
                                <option>Agustus</option>
                                <option>September</option>
                                <option>Oktober</option>
                                <option>November</option>
                                <option>Desember</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <select id="orgEndYear" class="form-select">
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
                               id="orgOngoing">
                        <label class="form-check-label">
                            Saya masih menjadi sukarelawan di sini
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Informasi tambahan (Opsional)
                    </label>
                    <textarea id="orgDesc"
                              class="form-control"
                              rows="3"
                              maxlength="2000"></textarea>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0">
                <button class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>
                <button class="btn btn-primary"
                        onclick="saveOrg()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>