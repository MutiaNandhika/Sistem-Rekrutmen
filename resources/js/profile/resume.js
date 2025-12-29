let resumeFile = null;

document.addEventListener('DOMContentLoaded', function () {
    const resumeInput = document.getElementById('resumeInput');
    if (!resumeInput) return;

    resumeInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (file.type !== 'application/pdf') {
            alert('Resume harus berupa PDF');
            this.value = '';
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran maksimal 5 MB');
            this.value = '';
            return;
        }

        const url = URL.createObjectURL(file);
        document.getElementById('resumePreview').style.display = 'block';
        document.getElementById('resumeFrame').src = url;
    });
});

function saveResume() {
    const input = document.getElementById('resumeInput');

    if (!input.files.length) {
        alert('Pilih file PDF terlebih dahulu');
        return;
    }

    resumeFile = input.files[0];
    renderResume();

    input.value = '';
}

function renderResume() {
    const output = document.getElementById('resumeOutput');

    if (!resumeFile) {
        output.innerHTML = 'Belum ada resume diunggah';
        output.classList.add('text-muted');
        return;
    }

    output.classList.remove('text-muted');

    output.innerHTML = `
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-primary">
                <i class="bi bi-file-earmark-pdf me-1"></i>
                ${resumeFile.name}
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-light"
                        data-bs-toggle="modal"
                        data-bs-target="#modalResume">
                    <i class="bi bi-pencil"></i>
                </button>

                <button class="btn btn-sm btn-light text-danger"
                        onclick="deleteResume()">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;
}

function deleteResume() {
    if (!confirm('Yakin ingin menghapus resume?')) return;

    resumeFile = null;
    document.getElementById('resumePreview').style.display = 'none';
    document.getElementById('resumeFrame').src = '';
    renderResume();
}