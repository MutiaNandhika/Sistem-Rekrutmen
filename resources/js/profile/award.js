document.addEventListener('DOMContentLoaded', () => {

    /* ================= GUARD ================= */
    const modal = document.getElementById('modalPenghargaan');
    const editIdInput = document.getElementById('achievementEditId');

    // bukan halaman profile → STOP
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
            showAlert({
                icon: 'warning',
                title: 'Periksa Data',
                text: 'Lengkapi semua field wajib',
                timer: null
            });
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
                showAlert({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Validasi gagal',
                    timer: null
                });
                return;
            }

            showAlert({
                icon: 'success',
                title: 'Berhasil',
                text: id
                    ? 'Penghargaan berhasil diperbarui'
                    : 'Penghargaan berhasil ditambahkan'
            });

            // reload tetap dipertahankan (sesuai fitur lama)
            setTimeout(() => {
                location.reload();
            }, 800);
        })
        .catch(err => {
            console.error(err);
            showAlert({
                icon: 'error',
                title: 'Gagal',
                text: 'Request gagal',
                timer: null
            });
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

        if (typeof Swal === 'undefined') {
            if (!confirm('Yakin ingin menghapus penghargaan ini?')) return;
            doDelete();
            return;
        }

        Swal.fire({
            title: 'Yakin?',
            text: 'Penghargaan akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (!result.isConfirmed) return;
            doDelete();
        });

        function doDelete() {
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

                showAlert({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Penghargaan berhasil dihapus'
                });
            })
            .catch(() => {
                showAlert({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal menghapus penghargaan',
                    timer: null
                });
            });
        }
    };

    /* ================= RESET MODAL ================= */
    modal.addEventListener('hidden.bs.modal', () => {

        editIdInput.value = '';

        document.querySelectorAll(
            '#modalPenghargaan input, #modalPenghargaan textarea, #modalPenghargaan select'
        ).forEach(el => el.value = '');
    });

});
