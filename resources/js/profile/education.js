function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.content : '';
}

/* ================= TAMBAH / UPDATE ================= */
window.addEducation = function () {

    const id = document.getElementById('educationEditId').value;

    const payload = {
        tingkat: document.getElementById('eduTingkat').value,
        nama_sekolah: document.getElementById('eduSchool').value,
        bidang_studi: document.getElementById('eduMajor').value,
        mulai_bulan: document.getElementById('eduStartMonth').value,
        mulai_tahun: document.getElementById('eduStartYear').value,
        selesai_bulan: document.getElementById('eduEndMonth').value,
        selesai_tahun: document.getElementById('eduEndYear').value,
        informasi_tambahan: document.getElementById('eduInfo').value,
    };

    const BASE_URL = '/pelamar/profile/educations';

    const url = id ? `${BASE_URL}/${id}` : BASE_URL;
    const method = id ? 'PUT' : 'POST';

    fetch(url, {
        method,
        headers: {
            'X-CSRF-TOKEN': csrfToken(),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(async res => {
        const data = await res.json();

        if (!res.ok) {
            console.error(data);
            alert('Validasi gagal:\n' + JSON.stringify(data.errors));
            return;
        }

        location.reload();
    })
    .catch(err => {
        console.error(err);
        alert('Request gagal');
    });
};

/* ================= EDIT ================= */
window.editEducation = function (id, edu) {
    document.getElementById('educationEditId').value = id;
    document.getElementById('eduTingkat').value = edu.tingkat;
    document.getElementById('eduSchool').value = edu.nama_sekolah;
    document.getElementById('eduMajor').value = edu.bidang_studi;
    document.getElementById('eduStartMonth').value = edu.mulai_bulan;
    document.getElementById('eduStartYear').value = edu.mulai_tahun;
    document.getElementById('eduEndMonth').value = edu.selesai_bulan;
    document.getElementById('eduEndYear').value = edu.selesai_tahun;
    document.getElementById('eduInfo').value = edu.informasi_tambahan ?? '';
};

/* ================= DELETE ================= */
window.deleteEducation = function (id) {
    if (!confirm('Yakin ingin menghapus pendidikan ini?')) return;

    fetch(`/pelamar/profile/educations/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken(),
            'Accept': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error();
        document.getElementById(`education-${id}`).remove();
    })
    .catch(() => alert('Gagal menghapus pendidikan'));
};

/* ================= RESET MODAL ================= */
document.getElementById('modalPendidikan')
    .addEventListener('hidden.bs.modal', () => {
        document.getElementById('educationEditId').value = '';
        document.querySelectorAll(
            '#modalPendidikan input, #modalPendidikan textarea, #modalPendidikan select'
        ).forEach(el => el.value = '');
    });
