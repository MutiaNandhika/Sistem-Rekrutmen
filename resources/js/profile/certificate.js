console.log('certificate.js loaded');

document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('modalSertifikat');
    const editIdInput = document.getElementById('certificateEditId');

    // bukan halaman profile → STOP
    if (!modal || !editIdInput) return;

    function csrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    /* ================= TAMBAH / UPDATE ================= */
    window.addCertificate = function () {

        const nama   = document.getElementById('certName').value.trim();
        const org    = document.getElementById('certIssuer').value.trim();
        const bulan  = document.getElementById('certIssueMonth').value;
        const tahun  = document.getElementById('certIssueYear').value;
        const noExp  = document.getElementById('certNoExpire').checked;
        const expM   = document.getElementById('certExpireMonth').value;
        const expY   = document.getElementById('certExpireYear').value;
        const desc   = document.getElementById('certDesc').value.trim();

        /* ===== VALIDASI WAJIB ===== */
        if (!nama || !org || !bulan || !tahun) {
            showAlert({
                icon: 'warning',
                title: 'Periksa Data',
                text: 'Lengkapi semua field wajib',
                timer: null
            });
            return;
        }

        /* ===== PAYLOAD ===== */
        const payload = {
            nama_sertifikat: nama,
            organisasi_penerbit: org,
            bulan_terbit: bulan,
            tahun_terbit: tahun,
            tanpa_expired: noExp,
            informasi_tambahan: desc || null
        };

        if (!noExp) {
            payload.bulan_expired = expM || null;
            payload.tahun_expired = expY || null;
        }

        const id = editIdInput.value;
        const BASE_URL = '/pelamar/profile/certificates';
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
                    text: 'Validasi gagal, periksa input',
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
    window.editCertificate = function (id, cert) {

        editIdInput.value = id;

        document.getElementById('certName').value = cert.nama_sertifikat;
        document.getElementById('certIssuer').value = cert.organisasi_penerbit;
        document.getElementById('certIssueMonth').value = cert.bulan_terbit;
        document.getElementById('certIssueYear').value = cert.tahun_terbit;

        document.getElementById('certNoExpire').checked = cert.tanpa_expired;

        document.getElementById('certExpireMonth').value =
            cert.tanpa_expired ? '' : cert.bulan_expired ?? '';

        document.getElementById('certExpireYear').value =
            cert.tanpa_expired ? '' : cert.tahun_expired ?? '';

        document.getElementById('certDesc').value =
            cert.informasi_tambahan ?? '';
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
            if (el.type === 'checkbox') el.checked = false;
            else el.value = '';
        });
    });

});
