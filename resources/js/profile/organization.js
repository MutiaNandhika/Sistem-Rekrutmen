console.log('organization.js loaded');

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
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    /* ================= TAMBAH / UPDATE ================= */
    window.saveOrg = function () {

        const id = editIdInput.value;

        const nama   = orgName.value.trim();
        const posisi = orgRole.value.trim();
        const bulan  = orgStartMonth.value;
        const tahun  = orgStartYear.value;
        const noEnd  = orgOngoing.checked;
        const endM   = orgEndMonth.value;
        const endY   = orgEndYear.value;
        const desc   = orgDesc.value.trim();
        const file   = orgFile.files[0];

        if (!nama || !posisi || !bulan || !tahun) {
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
                text: 'File bukti organisasi wajib diupload',
                timer: null
            });
            return;
        }

        if (!noEnd) {
            if (!endM || !endY) {
                showAlert({
                    icon: 'warning',
                    title: 'Periksa Data',
                    text: 'Tanggal selesai wajib diisi',
                    timer: null
                });
                return;
            }
        }

        const formData = new FormData();
        formData.append('nama_organisasi', nama);
        formData.append('posisi', posisi);
        formData.append('mulai_bulan', bulan);
        formData.append('mulai_tahun', tahun);
        formData.append('masih_aktif', noEnd ? 1 : 0);
        formData.append('informasi_tambahan', desc);

        if (!noEnd) {
            formData.append('selesai_bulan', endM);
            formData.append('selesai_tahun', endY);
        }

        if (file) {
            formData.append('file_bukti', file);
        }

        const BASE_URL = '/pelamar/profile/organizations';
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
                    ? 'Organisasi berhasil diperbarui'
                    : 'Organisasi berhasil ditambahkan'
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
    window.editOrganization = function (id) {

        const org = organizations.find(o => o.id === id);
        if (!org) return;

        document.getElementById('orgEditId').value = id;
        document.getElementById('organizationModalTitle').innerText =
            'Edit Organisasi';
        document.getElementById('orgName').value = org.nama_organisasi ?? '';
        document.getElementById('orgRole').value = org.posisi ?? '';
        document.getElementById('orgDesc').value = org.informasi_tambahan ?? '';
        document.getElementById('orgStartMonth').value = org.mulai_bulan ?? '';
        document.getElementById('orgStartYear').value = org.mulai_tahun ?? '';
        document.getElementById('orgOngoing').checked = !!org.masih_aktif;

        document.getElementById('orgEndMonth').value =
            org.masih_aktif ? '' : (org.selesai_bulan ?? '');

        document.getElementById('orgEndYear').value =
            org.masih_aktif ? '' : (org.selesai_tahun ?? '');

        const preview = document.getElementById('orgFilePreview');
        const link = document.getElementById('orgFileLink');

        if (org.file_url) {
            preview.classList.remove('d-none');
            link.href = org.file_url;
        } else {
            preview.classList.add('d-none');
            link.href = '#';
        }

        document.getElementById('orgFile').value = '';
    };


    /* ================= DELETE ================= */
    window.deleteOrganization = function (id) {

        if (typeof Swal === 'undefined') {
            if (!confirm('Yakin ingin menghapus organisasi ini?')) return;
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

                const el = document.getElementById(`organization-${id}`);
                if (el) el.remove();

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
                    text: 'Gagal menghapus organisasi',
                    timer: null
                });
            });
        }
    };


    /* ================= RESET MODAL ================= */
    modal.addEventListener('hidden.bs.modal', () => {

        editIdInput.value = '';
        document.getElementById('organizationModalTitle').innerText =
        'Tambah Organisasi';
        document.querySelectorAll(
            '#modalOrganisasi input, #modalOrganisasi textarea, #modalOrganisasi select'
        ).forEach(el => {
            if (el.type === 'checkbox') {
                el.checked = false;
            } else {
                el.value = '';
            }
        });

        // reset preview
        if (previewBox) previewBox.classList.add('d-none');
        if (previewLink) previewLink.href = '#';
    });

});
