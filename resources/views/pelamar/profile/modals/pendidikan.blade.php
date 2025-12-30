{{-- ================= MODAL PENDIDIKAN ================= --}}
<div class="modal fade" id="modalPendidikan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">

            {{-- HEADER --}}
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Tambah Pendidikan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body px-4">
                <input type="hidden" id="educationEditId">

                {{-- INFO --}}
                <div class="alert alert-light small">
                    Harap diperhatikan: Daftar sekolah/perguruan tinggi
                    yang disediakan hanya yang berlaku di Indonesia.
                </div>

                {{-- TINGKAT PENDIDIKAN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Tingkat Pendidikan <span class="text-danger">*</span>
                    </label>
                    <select id="eduTingkat" class="form-select">
                        <option value="">Pilih tingkat pendidikan</option>
                        <option>SMA / SMK</option>
                        <option>D3</option>
                        <option>S1</option>
                        <option>S2</option>
                        <option>S3</option>
                    </select>
                </div>

                {{-- NAMA SEKOLAH --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Sekolah / Perguruan Tinggi <span class="text-danger">*</span>
                    </label>
                    <input id="eduSchool" class="form-control">
                </div>

                {{-- BIDANG STUDI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Bidang Studi <span class="text-danger">*</span>
                    </label>
                    <input id="eduMajor" class="form-control">
                </div>

                {{-- DIMULAI --}}
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

                {{-- BERAKHIR --}}
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

                {{-- INFORMASI TAMBAHAN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Informasi Tambahan (Opsional)
                    </label>
                    <textarea id="eduInfo" class="form-control"></textarea>
                    <div class="text-end small text-muted">
                        0 / 2000
                    </div>
                </div>

            </div>

            {{-- FOOTER --}}
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

<script>
function addEducation() {
    const id = document.getElementById('educationEditId').value;

    const payload = {
        tingkat: eduTingkat.value,
        nama_sekolah: eduSchool.value,
        bidang_studi: eduMajor.value,
        mulai_bulan: eduStartMonth.value,
        mulai_tahun: eduStartYear.value,
        selesai_bulan: eduEndMonth.value,
        selesai_tahun: eduEndYear.value,
        informasi_tambahan: eduInfo.value,
    };


    const url = id
        ? `/pelamar/profile/educations/${id}`
        : `/pelamar/profile/educations`;

    const method = id ? 'PUT' : 'POST';

    fetch(url, {
        method,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(res => {
        if (!res.ok) throw new Error();
        return res.json();
    })
    .then(() => location.reload())
    .catch(() => alert('Gagal menyimpan pendidikan'));

}

function editEducation(id, edu) {
    document.getElementById('educationEditId').value = id;

    document.getElementById('eduTingkat').value = edu.tingkat;
    document.getElementById('eduSchool').value = edu.nama_sekolah;
    document.getElementById('eduMajor').value = edu.bidang_studi;
    document.getElementById('eduStartYear').value = edu.mulai_tahun;
    document.getElementById('eduStartMonth').value = edu.mulai_bulan;
    document.getElementById('eduEndMonth').value = edu.selesai_bulan;
    document.getElementById('eduEndYear').value = edu.selesai_tahun;
    document.getElementById('eduInfo').value = edu.informasi_tambahan ?? '';
}

function deleteEducation(id) {
    if (!confirm('Yakin ingin menghapus pendidikan ini?')) return;

    fetch(`/pelamar/profile/educations/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error();
        document.getElementById(`education-${id}`).remove();
    })
    .catch(() => alert('Gagal menghapus pendidikan'));
}

document.getElementById('modalPendidikan')
    .addEventListener('hidden.bs.modal', () => {
        document.getElementById('educationEditId').value = '';
        document.getElementById('eduTingkat').value = '';
        document.getElementById('eduSchool').value = '';
        document.getElementById('eduMajor').value = '';
        document.getElementById('eduStartYear').value = '';
        document.getElementById('eduEndMonth').value = '';
        document.getElementById('eduEndYear').value = '';
        document.getElementById('eduInfo').value = '';
});

</script>
