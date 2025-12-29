{{-- ================= MODAL RESUME ================= --}}
<div class="modal fade" id="modalResume" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Resume</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="file"
                       id="resumeInput"
                       class="form-control mb-3"
                       accept="application/pdf">

                {{-- PREVIEW PDF --}}
                <div id="resumePreview"
                     class="border rounded"
                     style="height:400px; display:none;">
                    <iframe id="resumeFrame"
                            style="width:100%; height:100%; border:0;"></iframe>
                </div>

                <small class="text-muted">
                    Format PDF • Maksimal 5 MB
                </small>

            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <button class="btn btn-primary"
                        onclick="saveResume()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>
