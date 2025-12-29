{{-- ================= MODAL PENDIDIKAN ================= --}}
<div class="modal fade" id="modalPendidikan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">

            {{-- HEADER --}}
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Tambah Pendidikan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body px-4">
                <input type="hidden" id="educationEditId">

                {{-- INFO --}}
                <div class="alert alert-light small">
                    Harap diperhatikan: Daftar sekolah/perguruan tinggi
                    yang disediakan hanya yang berlaku di Indonesia.
                </div>

                {{-- TINGKAT PENDIDIKAN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Tingkat Pendidikan <span class="text-danger">*</span>
                    </label>
                    <select class="form-select">
                        <option value="">Pilih tingkat pendidikan</option>
                        <option>SMA / SMK</option>
                        <option>D3</option>
                        <option>S1</option>
                        <option>S2</option>
                        <option>S3</option>
                    </select>
                </div>

                {{-- NAMA SEKOLAH --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Sekolah / Perguruan Tinggi <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                        id="eduSchool"
                        class="form-control"
                        placeholder="Contoh: Universitas Indonesia">
                </div>

                {{-- BIDANG STUDI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Bidang Studi <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                        id="eduMajor"
                        class="form-control"
                        placeholder="Contoh: Teknik Informatika">
                </div>

                {{-- DIMULAI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Dimulai <span class="text-danger">*</span>
                    </label>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <select id="eduStart" class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-6">
                            <select id="eduEnd" class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                {{-- BERAKHIR --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Berakhir <span class="text-danger">*</span>
                    </label>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <select class="form-select">
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

                        <div class="col-md-6">
                            <select class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                {{-- INFORMASI TAMBAHAN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Informasi Tambahan (Opsional)
                    </label>
                    <textarea class="form-control"
                              rows="4"
                              maxlength="2000"
                              placeholder="Contoh: Lulus dengan predikat cumlaude"></textarea>
                    <div class="text-end small text-muted">
                        0 / 2000
                    </div>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0">
                <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <button type="button"
                        class="btn btn-primary px-4"
                        onclick="addEducation()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>
