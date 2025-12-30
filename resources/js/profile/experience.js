function csrfToken() {
    return document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content');
}

/* ================= TAMBAH / UPDATE ================= */
window.addExperience = function () {

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
            'X-CSRF-TOKEN': csrfToken(),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(res => {
        if (!res.ok) throw new Error('Request gagal');
        return res.json();
    })
    .then(() => {
        location.reload();
    })
    .catch(err => {
        console.error(err);
        alert('Gagal menyimpan pengalaman');
    });
};

/* ================= EDIT ================= */
window.editExperience = function (id, exp) {

    document.getElementById('experienceEditId').value = id;
    document.getElementById('experienceModalTitle').innerText = 'Edit Pengalaman Kerja';

    document.getElementById('expPosition').value = exp.posisi;
    document.getElementById('expCompany').value = exp.perusahaan;
    document.getElementById('expStart').value = exp.tanggal_mulai.slice(0, 7);
    document.getElementById('expEnd').value = exp.tanggal_selesai
        ? exp.tanggal_selesai.slice(0, 7)
        : '';
    document.getElementById('expDescription').value = exp.deskripsi ?? '';
};

/* ================= RESET MODAL ================= */
document
    .getElementById('modalPengalamanKerja')
    .addEventListener('hidden.bs.modal', () => {

        document.getElementById('experienceEditId').value = '';
        document.getElementById('experienceModalTitle').innerText = 'Tambah Pengalaman Kerja';

        document.getElementById('expPosition').value = '';
        document.getElementById('expCompany').value = '';
        document.getElementById('expStart').value = '';
        document.getElementById('expEnd').value = '';
        document.getElementById('expDescription').value = '';
    });

/* ================= DELETE ================= */
window.deleteExperience = function (id) {

    if (!confirm('Yakin ingin menghapus pengalaman ini?')) return;

    fetch(`/pelamar/profile/experiences/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken(),
            'Accept': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error();
        document.getElementById(`experience-${id}`).remove();
    })
    .catch(() => {
        alert('Gagal menghapus pengalaman');
    });
};
