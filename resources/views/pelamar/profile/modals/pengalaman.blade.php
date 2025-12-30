{{-- ================= MODAL PENGALAMAN KERJA ================= --}}
<div class="modal fade" id="modalPengalamanKerja" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 rounded-4 shadow">

            {{-- HEADER --}}
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold" id="experienceModalTitle">
                    Tambah Pengalaman Kerja
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            

            <div class="modal-body px-4">
<input type="hidden" id="experienceEditId">
                {{-- POSISI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Posisi / Jabatan</label>
                    <input type="text"
                           class="form-control"
                           id="expPosition"
                           placeholder="Contoh: Admin Gudang">
                </div>

                {{-- PERUSAHAAN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Perusahaan</label>
                    <input type="text"
                           class="form-control"
                           id="expCompany"
                           placeholder="Contoh: PT Maju Jaya">
                </div>

                {{-- PERIODE --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Mulai</label>
                        <input type="month" class="form-control" id="expStart">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Selesai</label>
                        <input type="month" class="form-control" id="expEnd">
                        <small class="text-muted">Kosongkan jika masih bekerja</small>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi Pekerjaan</label>
                    <textarea class="form-control"
                              rows="4"
                              id="expDescription"
                              placeholder="Jelaskan tanggung jawab dan pencapaianmu"></textarea>
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
                        onclick="addExperience()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>

            </div>

        </div>

    </div>

</div>

<script>
function addExperience() {
    const id = document.getElementById('experienceEditId').value;

    const payload = {
        posisi: document.getElementById('expPosition').value,
        perusahaan: document.getElementById('expCompany').value,
        tanggal_mulai: document.getElementById('expStart').value + '-01',
        tanggal_selesai: document.getElementById('expEnd').value
            ? document.getElementById('expEnd').value + '-01'
            : null,
        masih_bekerja: document.getElementById('expEnd').value ? 0 : 1,
        deskripsi: document.getElementById('expDescription').value,
    };

    const url = id
        ? `/pelamar/profile/experiences/${id}`
        : `/pelamar/profile/experiences`;

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
        location.reload();
    })
    .catch(() => alert('Gagal menyimpan pengalaman'));
}


function editExperience(id, exp) {
    document.getElementById('experienceEditId').value = id;
    document.getElementById('experienceModalTitle').innerText = 'Edit Pengalaman Kerja';

    document.getElementById('expPosition').value = exp.posisi;
    document.getElementById('expCompany').value = exp.perusahaan;
    document.getElementById('expStart').value = exp.tanggal_mulai.slice(0, 7);
    document.getElementById('expEnd').value = exp.tanggal_selesai
        ? exp.tanggal_selesai.slice(0, 7)
        : '';
    document.getElementById('expDescription').value = exp.deskripsi ?? '';
}

document.getElementById('modalPengalamanKerja')
    .addEventListener('hidden.bs.modal', function () {

    document.getElementById('experienceEditId').value = '';
    document.getElementById('experienceModalTitle').innerText = 'Tambah Pengalaman Kerja';

    document.getElementById('expPosition').value = '';
    document.getElementById('expCompany').value = '';
    document.getElementById('expStart').value = '';
    document.getElementById('expEnd').value = '';
    document.getElementById('expDescription').value = '';
});

function deleteExperience(id) {
    if (!confirm('Yakin ingin menghapus pengalaman ini?')) return;

    fetch(`/pelamar/profile/experiences/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error();
        return res.json();
    })
    .then(() => {
        document.getElementById(`experience-${id}`).remove();
    })
    .catch(() => {
        alert('Gagal menghapus pengalaman');
    });
}

</script>

