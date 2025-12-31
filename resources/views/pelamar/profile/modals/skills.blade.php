{{-- ================= MODAL SKILLS ================= --}}
<div class="modal fade" id="modalSkills" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Skills</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <p class="text-muted small">
                    Pilih 3–10 skill terkuat kamu
                </p>

                <input id="skillInput"
                       class="form-control mb-3"
                       placeholder="Ketik skill lalu tekan Enter">

                <div id="skillPreview"
                     class="d-flex flex-wrap gap-2"></div>
            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <button class="btn btn-primary" 
                        onclick="saveSkills()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>
