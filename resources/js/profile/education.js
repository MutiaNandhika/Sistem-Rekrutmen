function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

/* ================= TAMBAH / UPDATE ================= */
window.addEducation = function () {

    const editId = document.getElementById('educationEditId').value;
    const fileInput = document.getElementById('eduFile');

    const tingkat = eduTingkat.value;
    const sekolah = eduSchool.value.trim();
    const jurusan = eduMajor.value.trim();
    const startM  = eduStartMonth.value;
    const startY  = eduStartYear.value;
    const endM    = eduEndMonth.value;
    const endY    = eduEndYear.value;
    const info    = eduInfo.value.trim();

    // ================= VALIDASI FIELD (SAMA SEPERTI SERTIFIKAT) =================
    if (!tingkat || !sekolah || !jurusan || !startM || !startY || !endM || !endY) {
        showAlert({
            icon: 'warning',
            title: 'Periksa Data',
            text: 'Lengkapi semua field wajib',
            timer: null
        });
        return;
    }

    // ================= VALIDASI FILE (HANYA SAAT TAMBAH) =================
    if (!editId && !fileInput.files.length) {
        showAlert({
            icon: 'warning',
            title: 'File Wajib',
            text: 'File bukti pendidikan wajib diupload',
            timer: null
        });
        return;
    }

    // ================= FORM DATA =================
    const formData = new FormData();
    formData.append('tingkat', tingkat);
    formData.append('nama_sekolah', sekolah);
    formData.append('bidang_studi', jurusan);
    formData.append('mulai_bulan', startM);
    formData.append('mulai_tahun', startY);
    formData.append('selesai_bulan', endM);
    formData.append('selesai_tahun', endY);
    formData.append('informasi_tambahan', info);

    if (fileInput.files.length) {
        formData.append('file_bukti', fileInput.files[0]);
    }

    if (editId) {
        formData.append('_method', 'PUT');
    }

    const url = editId
        ? `/pelamar/profile/educations/${editId}`
        : `/pelamar/profile/educations`;

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
                ? 'Pendidikan berhasil diperbarui'
                : 'Pendidikan berhasil ditambahkan'
        });

        setTimeout(() => location.reload(), 800);
    })
    .catch(() => {
        showAlert({
            icon: 'error',
            title: 'Gagal',
            text: 'Gagal menyimpan pendidikan',
            timer: null
        });
    });
};

/* ================= EDIT ================= */
window.editEducation = function (id, edu) {

    document.getElementById('educationEditId').value = id;

    eduTingkat.value = edu.tingkat ?? '';
    eduSchool.value = edu.nama_sekolah ?? '';
    eduMajor.value = edu.bidang_studi ?? '';
    eduStartMonth.value = edu.mulai_bulan ?? '';
    eduStartYear.value = edu.mulai_tahun ?? '';
    eduEndMonth.value = edu.selesai_bulan ?? '';
    eduEndYear.value = edu.selesai_tahun ?? '';
    eduInfo.value = edu.informasi_tambahan ?? '';

    const preview = document.getElementById('eduFilePreview');
    const link = document.getElementById('eduFileLink');

    if (edu.file_bukti) {
        preview.classList.remove('d-none');
        link.href = `/storage/${edu.file_bukti}`;
    } else {
        preview.classList.add('d-none');
        link.href = '#';
    }

    document.getElementById('eduFile').value = '';
};

/* ================= DELETE ================= */
window.deleteEducation = function (id) {

    Swal.fire({
        title: 'Yakin?',
        text: 'Pendidikan akan dihapus',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then(result => {
        if (!result.isConfirmed) return;

        fetch(`/pelamar/profile/educations/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Accept': 'application/json'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error();

            document.getElementById(`education-${id}`)?.remove();

            showAlert({
                icon: 'success',
                title: 'Berhasil',
                text: 'Pendidikan berhasil dihapus'
            });
        })
        .catch(() => {
            showAlert({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal menghapus pendidikan',
                timer: null
            });
        });
    });
};

/* ================= RESET MODAL ================= */
document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('modalPendidikan');
    if (!modal) return;

    modal.addEventListener('hidden.bs.modal', () => {

        document.getElementById('educationEditId').value = '';
        document.getElementById('eduFilePreview').classList.add('d-none');
        document.getElementById('eduFileLink').href = '#';
        document.getElementById('eduFile').value = '';

        modal.querySelectorAll('input, textarea, select')
            .forEach(el => el.value = '');
    });
});
