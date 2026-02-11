function csrfToken() {
    const token = document.querySelector('meta[name="csrf-token"]');
    return token ? token.getAttribute('content') : '';
}

/* ================= TAMBAH / UPDATE ================= */
window.addExperience = function () {

    const editId = document.getElementById('experienceEditId').value;
    const fileInput = document.getElementById('expFile');

    const posisi     = expPosition.value.trim();
    const perusahaan = expCompany.value.trim();
    const start      = expStart.value;
    const end        = expEnd.value;
    const desc       = expDescription.value.trim();

    if (!posisi || !perusahaan || !start) {
        showAlert({
            icon: 'warning',
            title: 'Periksa Data',
            text: 'Lengkapi semua field wajib',
            timer: null
        });
        return;
    }

    if (!editId && !fileInput.files.length) {
        showAlert({
            icon: 'warning',
            title: 'File Wajib',
            text: 'File bukti pengalaman kerja wajib diupload',
            timer: null
        });
        return;
    }

    const formData = new FormData();
    formData.append('posisi', posisi);
    formData.append('perusahaan', perusahaan);
    formData.append(
        'tanggal_mulai',
        start ? start + '-01' : ''
    );

    if (end) {
        formData.append('tanggal_selesai', end + '-01');
        formData.append('masih_bekerja', 0);
    } else {
        formData.append('masih_bekerja', 1);
    }

    formData.append('deskripsi', desc);

    if (fileInput.files.length) {
        formData.append('file_bukti', fileInput.files[0]);
    }

    if (editId) {
        formData.append('_method', 'PUT');
    }

    const url = editId
        ? `/pelamar/profile/experiences/${editId}`
        : `/pelamar/profile/experiences`;

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
            text: editId
                ? 'Pengalaman kerja berhasil diperbarui'
                : 'Pengalaman kerja berhasil ditambahkan'
        });

        setTimeout(() => location.reload(), 800);
    })
    .catch(() => {
        showAlert({
            icon: 'error',
            title: 'Gagal',
            text: 'Gagal menyimpan pengalaman',
            timer: null
        });
    });
};

/* ================= EDIT ================= */
window.editExperience = function (id, exp) {

    if (!exp) return;

    document.getElementById('experienceEditId').value = id;
    document.getElementById('experienceModalTitle').innerText =
        'Edit Pengalaman Kerja';

    document.getElementById('expPosition').value = exp.posisi ?? '';
    document.getElementById('expCompany').value = exp.perusahaan ?? '';
    document.getElementById('expStart').value =
        exp.tanggal_mulai ? exp.tanggal_mulai.slice(0, 7) : '';
    document.getElementById('expEnd').value =
        exp.tanggal_selesai ? exp.tanggal_selesai.slice(0, 7) : '';
    document.getElementById('expDescription').value =
        exp.deskripsi ?? '';

    const preview = document.getElementById('expFilePreview');
    const link = document.getElementById('expFileLink');

    if (exp.file_bukti) {
        preview.classList.remove('d-none');
        link.href = `/storage/${exp.file_bukti}`;
    } else {
        preview.classList.add('d-none');
        link.href = '#';
    }

    document.getElementById('expFile').value = '';
};

/* ================= DELETE ================= */
window.deleteExperience = function (id) {

    Swal.fire({
        title: 'Yakin?',
        text: 'Pengalaman kerja akan dihapus',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then(result => {
        if (!result.isConfirmed) return;

        fetch(`/pelamar/profile/experiences/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Accept': 'application/json'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error();

            document.getElementById(`experience-${id}`)?.remove();

            showAlert({
                icon: 'success',
                title: 'Berhasil',
                text: 'Pengalaman kerja berhasil dihapus'
            });
        })
        .catch(() => {
            showAlert({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal menghapus pengalaman',
                timer: null
            });
        });
    });
};

/* ================= RESET MODAL ================= */
document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('modalPengalamanKerja');
    if (!modal) return;

    modal.addEventListener('hidden.bs.modal', () => {

        document.getElementById('experienceEditId').value = '';
        document.getElementById('experienceModalTitle').innerText =
            'Tambah Pengalaman Kerja';

        document.getElementById('expPosition').value = '';
        document.getElementById('expCompany').value = '';
        document.getElementById('expStart').value = '';
        document.getElementById('expEnd').value = '';
        document.getElementById('expDescription').value = '';

        document.getElementById('expFilePreview').classList.add('d-none');
        document.getElementById('expFileLink').href = '#';
        document.getElementById('expFile').value = '';
    });
});
