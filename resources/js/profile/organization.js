document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('modalOrganisasi');
    const editIdInput = document.getElementById('orgEditId');

    if (!modal || !editIdInput) return;

    const orgName       = document.getElementById('orgName');
    const orgRole       = document.getElementById('orgRole');
    const orgStartMonth = document.getElementById('orgStartMonth');
    const orgStartYear  = document.getElementById('orgStartYear');
    const orgEndMonth   = document.getElementById('orgEndMonth');
    const orgEndYear    = document.getElementById('orgEndYear');
    const orgOngoing    = document.getElementById('orgOngoing');
    const orgDesc       = document.getElementById('orgDesc');
    const orgFile       = document.getElementById('orgFile');

    const previewBox  = document.getElementById('orgFilePreview');
    const previewLink = document.getElementById('orgFileLink');

    function csrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content;
    }

    /* ================= SIMPAN / UPDATE ================= */
    window.saveOrg = function () {

        const id = editIdInput.value;

        const nama  = orgName.value.trim();
        const posisi = orgRole.value.trim();
        const bulan  = orgStartMonth.value;
        const tahun  = orgStartYear.value;
        const file   = orgFile.files[0];

        // ================= VALIDASI FIELD (SAMA SEPERTI SERTIFIKAT) =================
        if (!nama || !posisi || !bulan || !tahun) {
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
                text: 'File bukti organisasi wajib diupload',
                timer: null
            });
            return;
        }

        // ================= FORM DATA =================
        const formData = new FormData();
        formData.append('nama_organisasi', nama);
        formData.append('posisi', posisi);
        formData.append('mulai_bulan', bulan);
        formData.append('mulai_tahun', tahun);
        formData.append('masih_aktif', orgOngoing.checked ? 1 : 0);
        formData.append('informasi_tambahan', orgDesc.value.trim());

        if (!orgOngoing.checked) {
            formData.append('selesai_bulan', orgEndMonth.value || '');
            formData.append('selesai_tahun', orgEndYear.value || '');
        }

        if (file) {
            formData.append('file_bukti', file);
        }

        const BASE_URL = '/pelamar/profile/organizations';
        const url = id ? `${BASE_URL}/${id}` : BASE_URL;

        if (id) formData.append('_method', 'PUT');

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
                    ? 'Organisasi berhasil diperbarui'
                    : 'Organisasi berhasil ditambahkan'
            });

            setTimeout(() => location.reload(), 800);
        })
        .catch(() => {
            showAlert({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal menyimpan data',
                timer: null
            });
        });
    };

    /* ================= EDIT ================= */
    window.editOrganization = function (id, org) {

        editIdInput.value = id;

        orgName.value       = org.nama_organisasi;
        orgRole.value       = org.posisi;
        orgDesc.value       = org.informasi_tambahan ?? '';
        orgStartMonth.value = org.mulai_bulan;
        orgStartYear.value  = org.mulai_tahun;
        orgOngoing.checked = !!org.masih_aktif;

        if (!org.masih_aktif) {
            orgEndMonth.value = org.selesai_bulan;
            orgEndYear.value  = org.selesai_tahun;
        } else {
            orgEndMonth.value = '';
            orgEndYear.value  = '';
        }

        // preview file
        if (org.file_bukti) {
            previewBox.classList.remove('d-none');
            previewLink.href = `/storage/${org.file_bukti}`;
        } else {
            previewBox.classList.add('d-none');
            previewLink.href = '#';
        }

        orgFile.value = '';

        new bootstrap.Modal(modal).show();
    };

    /* ================= DELETE ================= */
    window.deleteOrganization = function (id) {

        Swal.fire({
            title: 'Yakin?',
            text: 'Data organisasi akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (!result.isConfirmed) return;

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
        });
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
