document.addEventListener('DOMContentLoaded', () => {

    /* ================= GUARD ================= */
    const modal = document.getElementById('modalSertifikat');
    const editIdInput = document.getElementById('certificateEditId');

    // kalau bukan halaman profile → STOP
    if (!modal || !editIdInput) return;

    function csrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    /* ================= TAMBAH / UPDATE ================= */
    window.addCertificate = function () {

        const id = editIdInput.value;

        const payload = {
            nama_sertifikat: document.getElementById('certName').value,
            organisasi_penerbit: document.getElementById('certIssuer').value,
            bulan_terbit: document.getElementById('certIssueMonth').value,
            tahun_terbit: document.getElementById('certIssueYear').value,
            tanpa_expired: document.getElementById('certNoExpire').checked,
            bulan_expired: document.getElementById('certExpireMonth').value,
            tahun_expired: document.getElementById('certExpireYear').value,
            informasi_tambahan: document.getElementById('certDesc').value,
        };

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
                alert('Validasi gagal');
                return;
            }

            // ⬅️ PENTING: BIAR LIST SYNC
            location.reload();
        })
        .catch(() => alert('Request gagal'));
    };

    /* ================= EDIT ================= */
    window.editCertificate = function (id, cert) {

        editIdInput.value = id;

        document.getElementById('certName').value = cert.nama_sertifikat;
        document.getElementById('certIssuer').value = cert.organisasi_penerbit;
        document.getElementById('certIssueMonth').value = cert.bulan_terbit;
        document.getElementById('certIssueYear').value = cert.tahun_terbit;
        document.getElementById('certExpireMonth').value = cert.bulan_expired ?? '';
        document.getElementById('certExpireYear').value = cert.tahun_expired ?? '';
        document.getElementById('certNoExpire').checked = cert.tanpa_expired;
        document.getElementById('certDesc').value = cert.informasi_tambahan ?? '';
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
        ).forEach(el => el.value = '');
    });

});
