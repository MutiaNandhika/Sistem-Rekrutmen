document.addEventListener('DOMContentLoaded', () => {

    /* ================= GUARD ================= */
    const modal = document.getElementById('modalOrganisasi');
    const editIdInput = document.getElementById('orgEditId');

    // bukan halaman profile → STOP
    if (!modal || !editIdInput) return;

    function csrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    /* ================= SIMPAN / UPDATE ================= */
    window.saveOrg = function () {

        const id = editIdInput.value;

        const payload = {
            nama_organisasi: document.getElementById('orgName').value.trim(),
            posisi: document.getElementById('orgRole').value.trim(),
            mulai_bulan: document.getElementById('orgStartMonth').value,
            mulai_tahun: document.getElementById('orgStartYear').value,
            selesai_bulan: document.getElementById('orgEndMonth').value,
            selesai_tahun: document.getElementById('orgEndYear').value,
            masih_aktif: document.getElementById('orgOngoing').checked,
            informasi_tambahan: document.getElementById('orgDesc').value.trim(),
        };

        /* ===== VALIDASI WAJIB ===== */
        if (
            !payload.nama_organisasi ||
            !payload.posisi ||
            !payload.mulai_bulan ||
            !payload.mulai_tahun
        ) {
            showAlert({
                icon: 'warning',
                title: 'Periksa Data',
                text: 'Lengkapi semua field wajib',
                timer: null
            });
            return;
        }

        const BASE_URL = '/pelamar/profile/organizations';
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
            if (!res.ok) throw new Error();
            return res.json();
        })
        .then(() => {

            showAlert({
                icon: 'success',
                title: 'Berhasil',
                text: id
                    ? 'Organisasi berhasil diperbarui'
                    : 'Organisasi berhasil ditambahkan'
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
                text: 'Request gagal',
                timer: null
            });
        });
    };

    /* ================= EDIT ================= */
    window.editOrganization = function (id, org) {

        editIdInput.value = id;

        document.getElementById('orgName').value = org.nama_organisasi;
        document.getElementById('orgRole').value = org.posisi;
        document.getElementById('orgDesc').value = org.informasi_tambahan ?? '';

        document.getElementById('orgStartMonth').value = org.mulai_bulan;
        document.getElementById('orgStartYear').value  = org.mulai_tahun;

        document.getElementById('orgOngoing').checked = !!org.masih_aktif;

        if (!org.masih_aktif) {
            document.getElementById('orgEndMonth').value = org.selesai_bulan;
            document.getElementById('orgEndYear').value  = org.selesai_tahun;
        } else {
            document.getElementById('orgEndMonth').value = '';
            document.getElementById('orgEndYear').value  = '';
        }

        // buka modal (tetap seperti fitur lama)
        new bootstrap.Modal(modal).show();
    };

    /* ================= DELETE ================= */
    window.deleteOrganization = function (id) {

        if (typeof Swal === 'undefined') {
            if (!confirm('Yakin ingin menghapus data ini?')) return;
            doDelete();
            return;
        }

        Swal.fire({
            title: 'Yakin?',
            text: 'Data organisasi akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (!result.isConfirmed) return;
            doDelete();
        });

        function doDelete() {
            fetch(`/pelamar/profile/organizations/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken(),
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error();

                document.getElementById(`organization-${id}`)?.remove();

                showAlert({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Organisasi berhasil dihapus'
                });
            })
            .catch(() => {
                showAlert({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal menghapus data',
                    timer: null
                });
            });
        }
    };

});
