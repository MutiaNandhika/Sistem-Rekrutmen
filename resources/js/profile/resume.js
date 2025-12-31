function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

document.addEventListener('DOMContentLoaded', () => {

    const input = document.getElementById('resumeInput');
    if (!input) return;

    input.addEventListener('change', () => {
        const file = input.files[0];
        if (!file) return;

        if (file.type !== 'application/pdf') {
            alert('Resume harus PDF');
            input.value = '';
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert('Maksimal 5 MB');
            input.value = '';
            return;
        }

        document.getElementById('resumePreview').style.display = 'block';
        document.getElementById('resumeFrame').src =
            URL.createObjectURL(file);
    });
});

window.saveResume = function () {

    const input = document.getElementById('resumeInput');
    if (!input.files.length) {
        alert('Pilih file terlebih dahulu');
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
        location.reload();
    })
    .catch(() => alert('Gagal upload resume'));
};

window.deleteResume = function () {

    if (!confirm('Yakin hapus resume?')) return;

    fetch('/pelamar/profile/resume', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken(),
            'Accept': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error();
        location.reload();
    })
    .catch(() => alert('Gagal hapus resume'));
};
