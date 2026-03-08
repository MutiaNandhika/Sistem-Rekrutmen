<div class="modal fade" id="modalPenghargaan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">

            <div class="modal-header border-0">
            <h6 class="modal-title fw-bold" id="achievementModalTitle">
                Tambah Penghargaan
            </h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="achievementEditId">

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Judul <span class="text-danger">*</span>
                    </label>
                    <input id="awardJudul" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Penyelenggara <span class="text-danger">*</span>
                    </label>
                    <input id="awardPenyelenggara" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tahun <span class="text-danger">*</span>
                    </label>
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

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        File Bukti Penghargaan <span class="text-danger">*</span>
                    </label>
                    <input type="file"
                        id="awardFile"
                        class="form-control"
                        accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">
                        Sertifikat / Piagam (PDF / JPG / PNG)
                    </small>
                </div>

                <div class="mb-3 d-none" id="awardFilePreview">
                    <label class="form-label fw-semibold">File Saat Ini</label>
                    <div>
                        <a href="#"
                        id="awardFileLink"
                        target="_blank"
                        class="fw-semibold text-primary">
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
                        onclick="addAchievement()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>

@php
    $achievementsData = $user->pelamarAchievements->map(function($award) {
        return [
            'id' => $award->id,
            'judul' => $award->judul,
            'penyelenggara' => $award->penyelenggara,
            'tahun' => $award->tahun,
            'deskripsi' => $award->deskripsi,
            'file_url' => $award->file_bukti
                ? \Storage::disk('s3')->url($award->file_bukti)
                : null,
        ];
    });
@endphp

<script>
    const achievements = @json($achievementsData);
</script>