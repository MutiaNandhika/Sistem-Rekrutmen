console.log('certificate.js loaded');

document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('modalSertifikat');
    const editIdInput = document.getElementById('certificateEditId');

    if (!modal || !editIdInput) return;

    function csrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    /* ================= TAMBAH / UPDATE ================= */
    window.addCertificate = function () {

        const id = editIdInput.value;

        const nama  = document.getElementById('certName').value.trim();
        const org   = document.getElementById('certIssuer').value.trim();
        const bulan = document.getElementById('certIssueMonth').value;
        const tahun = document.getElementById('certIssueYear').value;
        const noExp = document.getElementById('certNoExpire').checked;
        const expM  = document.getElementById('certExpireMonth').value;
        const expY  = document.getElementById('certExpireYear').value;
        const desc  = document.getElementById('certDesc').value.trim();
        const file  = document.getElementById('certFile').files[0];

        if (!nama || !org || !bulan || !tahun) {
            showAlert({
                icon: 'warning',
                title: 'Periksa Data',
                text: 'Lengkapi semua field wajib',
                timer: null
            });
            return;
        }

        if (!id && !file) {
            showAlert({
                icon: 'warning',
                title: 'File Wajib',
                text: 'File bukti sertifikat wajib diupload',
                timer: null
            });
            return;
        }

        if (!noExp) {
            if (!expM || !expY) {
                showAlert({
                    icon: 'warning',
                    title: 'Periksa Data',
                    text: 'Tanggal expired wajib diisi',
                    timer: null
                });
                return;
            }
        }

        const formData = new FormData();
        formData.append('nama_sertifikat', nama);
        formData.append('organisasi_penerbit', org);
        formData.append('bulan_terbit', bulan);
        formData.append('tahun_terbit', tahun);
        formData.append('tanpa_expired', noExp ? 1 : 0);
        formData.append('informasi_tambahan', desc);

        if (!noExp) {
            formData.append('bulan_expired', expM);
            formData.append('tahun_expired', expY);
        }

        if (file) {
            formData.append('file_bukti', file);
        }

        const BASE_URL = '/pelamar/profile/certificates';
        const url = id ? `${BASE_URL}/${id}` : BASE_URL;

        if (id) {
            formData.append('_method', 'PUT');
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async res => {
            const data = await res.json();

            if (!res.ok) {
                console.error(data);
                showAlert({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Validasi gagal',
                    timer: null
                });
                return;
            }

            showAlert({
                icon: 'success',
                title: 'Berhasil',
                text: id
                    ? 'Sertifikat berhasil diperbarui'
                    : 'Sertifikat berhasil ditambahkan'
            });

            setTimeout(() => location.reload(), 800);
        })
        .catch(() => {
            showAlert({
                icon: 'error',
                title: 'Gagal',
                text: 'Request gagal',
                timer: null
            });
        });
    };


    /* ================= EDIT ================= */
    window.editCertificate = function (id, cert) {

        editIdInput.value = id;

        document.getElementById('certName').value = cert.nama_sertifikat;
        document.getElementById('certIssuer').value = cert.organisasi_penerbit;
        document.getElementById('certIssueMonth').value = cert.bulan_terbit;
        document.getElementById('certIssueYear').value = cert.tahun_terbit;
        document.getElementById('certNoExpire').checked = !!cert.tanpa_expired;

        document.getElementById('certExpireMonth').value =
            cert.tanpa_expired ? '' : (cert.bulan_expired ?? '');

        document.getElementById('certExpireYear').value =
            cert.tanpa_expired ? '' : (cert.tahun_expired ?? '');

        document.getElementById('certDesc').value =
            cert.informasi_tambahan ?? '';

        const preview = document.getElementById('certFilePreview');
        const link = document.getElementById('certFileLink');

        if (cert.file_bukti) {
            preview.classList.remove('d-none');
            link.href = `/storage/${cert.file_bukti}`;
        } else {
            preview.classList.add('d-none');
            link.href = '#';
        }

        document.getElementById('certFile').value = '';
    };


    /* ================= DELETE ================= */
    window.deleteCertificate = function (id) {

        if (typeof Swal === 'undefined') {
            if (!confirm('Yakin ingin menghapus sertifikat ini?')) return;
            doDelete();
            return;
        }

        Swal.fire({
            title: 'Yakin?',
            text: 'Sertifikat akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (!result.isConfirmed) return;
            doDelete();
        });

        function doDelete() {
            fetch(`/pelamar/profile/certificates/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken(),
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error();

                const el = document.getElementById(`certificate-${id}`);
                if (el) el.remove();

                showAlert({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Sertifikat berhasil dihapus'
                });
            })
            .catch(() => {
                showAlert({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal menghapus sertifikat',
                    timer: null
                });
            });
        }
    };


    /* ================= RESET MODAL ================= */
    modal.addEventListener('hidden.bs.modal', () => {

        editIdInput.value = '';

        document.querySelectorAll(
            '#modalSertifikat input, #modalSertifikat textarea, #modalSertifikat select'
        ).forEach(el => {
            if (el.type === 'checkbox') {
                el.checked = false;
            } else {
                el.value = '';
            }
        });

        // reset preview
        const preview = document.getElementById('certFilePreview');
        const link = document.getElementById('certFileLink');
        if (preview) preview.classList.add('d-none');
        if (link) link.href = '#';
    });

});
