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
            alert('Lengkapi semua field wajib');
            return;
        }

        /* ===== PAYLOAD BERSIH ===== */
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
                alert('Validasi gagal, cek input');
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

        if (!confirm('Yakin ingin menghapus sertifikat ini?')) return;

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
        })
        .catch(() => alert('Gagal menghapus sertifikat'));
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
