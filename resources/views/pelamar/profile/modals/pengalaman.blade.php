<div class="modal fade" id="modalPengalamanKerja" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold" id="experienceModalTitle">
                    Tambah Pengalaman Kerja
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4">
                <input type="hidden" id="experienceEditId">

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Posisi / Jabatan <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        id="expPosition">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Perusahaan <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        id="expCompany">
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Mulai <span class="text-danger">*</span>
                        </label>
                        <input
                            type="month"
                            class="form-control"
                            id="expStart">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Selesai</label>
                        <input
                            type="month"
                            class="form-control"
                            id="expEnd">
                        <small class="text-muted">
                            Kosongkan jika masih bekerja
                        </small>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi Pekerjaan</label>
                    <textarea
                        class="form-control"
                        rows="4"
                        id="expDescription"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        File Bukti Pengalaman
                        <span class="text-danger">*</span>
                    </label>
                    <input
                        type="file"
                        class="form-control"
                        id="expFile"
                        accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">
                        Surat pengalaman kerja / kontrak / paklaring (PDF / JPG / PNG)
                    </small>
                </div>

                <div class="mb-3 d-none" id="expFilePreview">
                    <label class="form-label fw-semibold">File Saat Ini</label>
                    <div>
                        <a
                            href="#"
                            target="_blank"
                            class="text-primary fw-semibold"
                            id="expFileLink">
                            <i class="bi bi-paperclip"></i> Lihat File
                        </a>
                    </div>
                    <small class="text-muted">
                        Upload file baru jika ingin mengganti
                    </small>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">
                    Batal
                </button>

                <button
                    type="button"
                    class="btn btn-primary px-4"
                    onclick="addExperience()"
                    data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>

</div>
