<div class="modal fade" id="modalPenghargaan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">

            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Tambah Penghargaan</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="achievementEditId">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul *</label>
                    <input id="awardJudul" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Penyelenggara *</label>
                    <input id="awardPenyelenggara" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tahun *</label>
                    <select id="awardTahun" class="form-select">
                        <option value="">Pilih tahun</option>
                        @for ($year = date('Y'); $year >= 1980; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea id="awardDeskripsi" class="form-control"></textarea>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary"
                        onclick="addAchievement()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>
