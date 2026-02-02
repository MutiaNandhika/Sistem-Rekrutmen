<div class="modal fade" id="modalSkills" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Skills</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <p class="text-muted small">
                    Pilih dari daftar atau tambahkan skill baru
                </p>

                {{-- DROPDOWN --}}
                <select id="skillSelect" class="form-select mb-2">
                    <option value="">Pilih skill</option>
                    @foreach(\App\Models\Skill::orderBy('nama_skill')->get() as $skill)
                        <option value="{{ $skill->id }}">
                            {{ $skill->nama_skill }}
                        </option>
                    @endforeach
                </select>

                {{-- INPUT MANUAL --}}
                <input type="text"
                       id="customSkill"
                       class="form-control mb-3"
                       placeholder="Atau ketik skill baru lalu Enter">

                <div id="skillPreview" class="d-flex flex-wrap gap-2"></div>
            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-light" data-bs-dismiss="modal">
                    Batal
                </button>

                <button class="btn btn-primary" id="btnSaveSkills">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>
