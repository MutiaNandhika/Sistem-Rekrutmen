<div class="modal fade" id="modalPendidikan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold" id="educationModalTitle">
                    Tambah Pendidikan
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4">
                <input type="hidden" id="educationEditId">

                <div class="alert alert-light small">
                    Harap diperhatikan: Daftar sekolah/perguruan tinggi
                    yang disediakan hanya yang berlaku di Indonesia.
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Tingkat Pendidikan <span class="text-danger">*</span>
                    </label>
                    <select id="eduTingkat" class="form-select">
                        <option value="">Pilih tingkat pendidikan</option>
                        <option>SMA</option>
                        <option>SMK</option>
                        <option>D3</option>
                        <option>S1</option>
                        <option>S2</option>
                        <option>S3</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Sekolah / Perguruan Tinggi <span class="text-danger">*</span>
                    </label>
                    <input id="eduSchool" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Bidang Studi <span class="text-danger">*</span>
                    </label>
                    <input id="eduMajor" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Dimulai <span class="text-danger">*</span>
                    </label>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <select id="eduStartYear" class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-6">
                            <select id="eduStartMonth" class="form-select">
                                <option value="">Bulan</option>
                                @for ($i=1; $i<=12; $i++)
                                    <option value="{{ $i }}">{{ DateTime::createFromFormat('!m',$i)->format('F') }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Berakhir <span class="text-danger">*</span>
                    </label>
                    
                    <div class="row g-2">
                        <div class="col-md-6">
                            <select id="eduEndYear" class="form-select">
                                <option value="">Tahun</option>
                                @for ($year = date('Y'); $year >= 1980; $year--)
                                    <option>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select id="eduEndMonth" class="form-select">
                                <option value="">Bulan</option>
                                @for ($i=1; $i<=12; $i++)
                                    <option value="{{ $i }}">{{ DateTime::createFromFormat('!m',$i)->format('F') }}</option>
                                @endfor
                            </select>
                        </div>

                        
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Informasi Tambahan (Opsional)
                    </label>
                    <textarea id="eduInfo" class="form-control"></textarea>
                    <div class="text-end small text-muted">
                        0 / 2000
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        File Bukti Pendidikan <span class="text-danger">*</span>
                    </label>
                    <input type="file"
                        id="eduFile"
                        class="form-control"
                        accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">
                        Ijazah / Transkrip (PDF / JPG / PNG)
                    </small>
                </div>

                <div class="mb-3 d-none" id="eduFilePreview">
                    <label class="form-label fw-semibold">File Saat Ini</label>
                    <div>
                        <a href="#" target="_blank"
                        class="fw-semibold text-primary"
                        id="eduFileLink">
                            <i class="bi bi-paperclip"></i> Lihat File
                        </a>
                    </div>
                    <small class="text-muted">
                        Upload file baru jika ingin mengganti
                    </small>
                </div>

            </div>

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

@php
    $educationsData = $user->pelamarEducations->map(function($edu) {
        return [
            'id' => $edu->id,
            'tingkat' => $edu->tingkat,
            'nama_sekolah' => $edu->nama_sekolah,
            'bidang_studi' => $edu->bidang_studi,
            'mulai_bulan' => $edu->mulai_bulan,
            'mulai_tahun' => $edu->mulai_tahun,
            'selesai_bulan' => $edu->selesai_bulan,
            'selesai_tahun' => $edu->selesai_tahun,
            'informasi_tambahan' => $edu->informasi_tambahan,
            'file_url' => $edu->file_bukti
                ? \Storage::disk('s3')->url($edu->file_bukti)
                : null,
        ];
    });
@endphp

<script>
    const educations = @json($educationsData);
</script>