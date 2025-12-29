{{-- ================= MODAL PENGHARGAAN ================= --}}
<div class="modal fade" id="modalPenghargaan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Tambah Penghargaan</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="awardEditId">

                <div class="mb-3">
                    <label class="form-label">Judul Penghargaan *</label>
                    <input type="text"
                           id="awardTitle"
                           class="form-control"
                           placeholder="Contoh: Juara 1 Lomba Desain">
                </div>

                <div class="mb-3">
                    <label class="form-label">Prestasi / Kontribusi *</label>
                    <input type="text"
                           id="awardRole"
                           class="form-control"
                           placeholder="Contoh: Desainer Utama">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun *</label>
                    <select id="awardYear" class="form-select">
                        <option value="">Pilih tahun</option>
                        @for ($year = date('Y'); $year >= 1980; $year--)
                            <option>{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Informasi Tambahan (Opsional)</label>
                    <textarea id="awardDesc"
                              class="form-control"
                              rows="3"
                              maxlength="2000"></textarea>
                </div>

            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <button class="btn btn-primary"
                        onclick="saveAward()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>
