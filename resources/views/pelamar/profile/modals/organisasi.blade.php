<div class="modal fade" id="modalOrganisasi" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">
                    Tambah Pengalaman Organisasi & Relawan
                </h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="orgEditId">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Organisasi *</label>
                    <input id="orgName" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Posisi *</label>
                    <input id="orgRole" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Mulai *</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <select id="orgStartMonth" class="form-select">
                                <option value="">Bulan</option>
                                @for ($i=1;$i<=12;$i++)
                                    <option value="{{ $i }}">
                                        {{ DateTime::createFromFormat('!m',$i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-6">
                            <select id="orgStartYear" class="form-select">
                                <option value="">Tahun</option>
                                @for ($y=date('Y');$y>=1980;$y--)
                                    <option>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Selesai</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <select id="orgEndMonth" class="form-select">
                                <option value="">Bulan</option>
                                @for ($i=1;$i<=12;$i++)
                                    <option value="{{ $i }}">
                                        {{ DateTime::createFromFormat('!m',$i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-6">
                            <select id="orgEndYear" class="form-select">
                                <option value="">Tahun</option>
                                @for ($y=date('Y');$y>=1980;$y--)
                                    <option>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-check mt-2">
                        <input id="orgOngoing" type="checkbox" class="form-check-input">
                        <label class="form-check-label">
                            Saya masih aktif
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Informasi Tambahan</label>
                    <textarea id="orgDesc" class="form-control"></textarea>
                </div>

            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary"
                        onclick="saveOrg()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>
