document.addEventListener('DOMContentLoaded', () => {

    /* ================= GUARD ================= */
    const input   = document.getElementById('resumeInput');
    const preview = document.getElementById('resumePreview');
    const frame   = document.getElementById('resumeFrame');

    if (!input) return;

    function csrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    /* ================= PREVIEW ================= */
    input.addEventListener('change', () => {
        const file = input.files[0];
        if (!file) return;

        if (file.type !== 'application/pdf') {
            showAlert({
                icon: 'warning',
                title: 'Format Salah',
                text: 'Resume harus berupa file PDF',
                timer: null
            });
            input.value = '';
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            showAlert({
                icon: 'warning',
                title: 'Ukuran Terlalu Besar',
                text: 'Maksimal ukuran file 5 MB',
                timer: null
            });
            input.value = '';
            return;
        }

        if (preview && frame) {
            preview.style.display = 'block';
            frame.src = URL.createObjectURL(file);
        }
    });

    /* ================= UPLOAD ================= */
    window.saveResume = function () {

        if (!input.files.length) {
            showAlert({
                icon: 'warning',
                title: 'Periksa File',
                text: 'Pilih file resume terlebih dahulu',
                timer: null
            });
            return;
        }

        const formData = new FormData();
        formData.append('resume', input.files[0]);

        fetch('/pelamar/profile/resume', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken()
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
                text: 'Resume berhasil disimpan'
            });

            // reload tetap dipertahankan (sesuai flow lama)
            setTimeout(() => {
                location.reload();
            }, 800);
        })
        .catch(() => {
            showAlert({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal upload resume',
                timer: null
            });
        });
    };

    /* ================= DELETE ================= */
    window.deleteResume = function () {

        if (typeof Swal === 'undefined') {
            if (!confirm('Yakin hapus resume?')) return;
            doDelete();
            return;
        }

        Swal.fire({
            title: 'Yakin?',
            text: 'Resume akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (!result.isConfirmed) return;
            doDelete();
        });

        function doDelete() {
            fetch('/pelamar/profile/resume', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken(),
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error();

                showAlert({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Resume berhasil dihapus'
                });

                // reload tetap dipertahankan
                setTimeout(() => {
                    location.reload();
                }, 800);
            })
            .catch(() => {
                showAlert({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal hapus resume',
                    timer: null
                });
            });
        }
    };

});
