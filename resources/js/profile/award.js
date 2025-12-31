function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.content : '';
}

/* ================= TAMBAH / UPDATE ================= */
window.addAchievement = function () {

    const id = document.getElementById('achievementEditId').value;

    const payload = {
        judul: document.getElementById('awardJudul').value,
        penyelenggara: document.getElementById('awardPenyelenggara').value,
        tahun: document.getElementById('awardTahun').value,
        deskripsi: document.getElementById('awardDeskripsi').value,
    };

    const BASE_URL = '/pelamar/profile/achievements';
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
            alert('Validasi gagal');
            console.error(data);
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
window.editAchievement = function (id, award) {

    document.getElementById('achievementEditId').value = id;
    document.getElementById('awardJudul').value = award.judul;
    document.getElementById('awardPenyelenggara').value = award.penyelenggara;
    document.getElementById('awardTahun').value = award.tahun;
    document.getElementById('awardDeskripsi').value = award.deskripsi ?? '';
};

/* ================= DELETE ================= */
window.deleteAchievement = function (id) {

    if (!confirm('Yakin ingin menghapus penghargaan ini?')) return;

    fetch(`/pelamar/profile/achievements/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken(),
            'Accept': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error();
        document.getElementById(`achievement-${id}`).remove();
    })
    .catch(() => alert('Gagal menghapus penghargaan'));
};

/* ================= RESET MODAL ================= */
document.getElementById('modalPenghargaan')
    .addEventListener('hidden.bs.modal', () => {
        document.getElementById('achievementEditId').value = '';
        document.querySelectorAll(
            '#modalPenghargaan input, #modalPenghargaan textarea, #modalPenghargaan select'
        ).forEach(el => el.value = '');
    });
