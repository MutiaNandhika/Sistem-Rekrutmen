<div class="modal fade" id="modalTentangSaya" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Tentang Saya</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4">
                <p class="text-muted small mb-2">
                    Beritahu tentang dirimu sehingga perusahaan lebih mudah memahami potensimu.
                </p>

                <textarea
                    id="tentangSayaInput"
                    class="form-control"
                    rows="5"
                    maxlength="2600"
                    placeholder="Ceritakan tentang dirimu..."
                    oninput="updateCounter()">{{ $user->pelamarProfile->tentang_saya }}</textarea>

                <div class="d-flex justify-content-end mt-1">
                    <small class="text-muted">
                        <span id="charCount">0</span> / 2600
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
                    onclick="saveTentangSaya()"
                    data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>

</div>
