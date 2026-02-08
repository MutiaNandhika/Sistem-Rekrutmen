document.addEventListener('DOMContentLoaded', () => {

    /* ================= GUARD ================= */
    const modal = document.getElementById('modalPenghargaan');
    const editIdInput = document.getElementById('achievementEditId');

    if (!modal || !editIdInput) return;

    function csrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    /* ================= TAMBAH / UPDATE ================= */
    window.addAchievement = function () {

        const id = editIdInput.value;

        const judul = awardJudul.value.trim();
        const penyelenggara = awardPenyelenggara.value.trim();
        const tahun = awardTahun.value;
        const deskripsi = awardDeskripsi.value.trim();
        const file = document.getElementById('awardFile').files[0];

        // ================= VALIDASI FIELD (SAMA SEPERTI SERTIFIKAT) =================
        if (!judul || !penyelenggara || !tahun) {
            showAlert({
                icon: 'warning',
                title: 'Periksa Data',
                text: 'Lengkapi semua field wajib',
                timer: null
            });
            return;
        }

        // ================= VALIDASI FILE (HANYA SAAT TAMBAH) =================
        if (!id && !file) {
            showAlert({
                icon: 'warning',
                title: 'File Wajib',
                text: 'File bukti penghargaan wajib diupload',
                timer: null
            });
            return;
        }

        // ================= FORM DATA =================
        const formData = new FormData();
        formData.append('judul', judul);
        formData.append('penyelenggara', penyelenggara);
        formData.append('tahun', tahun);
        formData.append('deskripsi', deskripsi);

        if (file) {
            formData.append('file_bukti', file);
        }

        if (id) {
            formData.append('_method', 'PUT');
        }

        const url = id
            ? `/pelamar/profile/achievements/${id}`
            : `/pelamar/profile/achievements`;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => {
            if (!res.ok) throw new Error();
            return res.json();
        })
        .then(() => {
            showAlert({
                icon: 'success',
                title: 'Berhasil',
                text: id
                    ? 'Penghargaan berhasil diperbarui'
                    : 'Penghargaan berhasil ditambahkan'
            });

            setTimeout(() => location.reload(), 800);
        })
        .catch(() => {
            showAlert({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal menyimpan penghargaan',
                timer: null
            });
        });
    };

    /* ================= EDIT ================= */
    window.editAchievement = function (id, award) {

        editIdInput.value = id;

        awardJudul.value = award.judul ?? '';
        awardPenyelenggara.value = award.penyelenggara ?? '';
        awardTahun.value = award.tahun ?? '';
        awardDeskripsi.value = award.deskripsi ?? '';

        const preview = document.getElementById('awardFilePreview');
        const link = document.getElementById('awardFileLink');

        if (award.file_bukti) {
            preview.classList.remove('d-none');
            link.href = `/storage/${award.file_bukti}`;
        } else {
            preview.classList.add('d-none');
            link.href = '#';
        }

        document.getElementById('awardFile').value = '';
    };

    /* ================= DELETE ================= */
    window.deleteAchievement = function (id) {

        Swal.fire({
            title: 'Yakin?',
            text: 'Penghargaan akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (!result.isConfirmed) return;

            fetch(`/pelamar/profile/achievements/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken(),
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error();

                document.getElementById(`achievement-${id}`)?.remove();

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
        });
    };

    /* ================= RESET MODAL ================= */
    modal.addEventListener('hidden.bs.modal', () => {

        editIdInput.value = '';

        document.getElementById('awardFilePreview').classList.add('d-none');
        document.getElementById('awardFileLink').href = '#';
        document.getElementById('awardFile').value = '';

        document.querySelectorAll(
            '#modalPenghargaan input, #modalPenghargaan textarea, #modalPenghargaan select'
        ).forEach(el => el.value = '');
    });

});
