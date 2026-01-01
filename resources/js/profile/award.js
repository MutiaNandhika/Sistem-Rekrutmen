document.addEventListener('DOMContentLoaded', () => {

    /* ================= GUARD ================= */
    const modal = document.getElementById('modalPenghargaan');
    const editIdInput = document.getElementById('achievementEditId');

    // jika bukan halaman profile → STOP
    if (!modal || !editIdInput) return;

    function csrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    /* ================= TAMBAH / UPDATE ================= */
    window.addAchievement = function () {

        const id = editIdInput.value;

        const payload = {
            judul: document.getElementById('awardJudul').value.trim(),
            penyelenggara: document.getElementById('awardPenyelenggara').value.trim(),
            tahun: document.getElementById('awardTahun').value,
            deskripsi: document.getElementById('awardDeskripsi').value.trim(),
        };

        if (!payload.judul || !payload.penyelenggara || !payload.tahun) {
            alert('Lengkapi data wajib');
            return;
        }

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
                console.error(data);
                alert('Validasi gagal');
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

        editIdInput.value = id;

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

            const el = document.getElementById(`achievement-${id}`);
            if (el) el.remove();
        })
        .catch(() => {
            alert('Gagal menghapus penghargaan');
        });
    };

    /* ================= RESET MODAL ================= */
    modal.addEventListener('hidden.bs.modal', () => {

        editIdInput.value = '';

        document.querySelectorAll(
            '#modalPenghargaan input, #modalPenghargaan textarea, #modalPenghargaan select'
        ).forEach(el => el.value = '');
    });

});
