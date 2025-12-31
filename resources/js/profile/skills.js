document.addEventListener('DOMContentLoaded', function () {

    const skillInput   = document.getElementById('skillInput');
    const skillPreview = document.getElementById('skillPreview');
    const skillsList   = document.getElementById('skillsList');

    let skills = [];

    function csrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.content : '';
    }

    /* ================= TAMBAH KE ARRAY ================= */
    function addSkill(value) {
        value = value.trim();
        if (!value) return;
        if (skills.includes(value)) return;
        if (skills.length >= 10) {
            alert('Maksimal 10 skill');
            return;
        }
        skills.push(value);
        renderPreview();
    }

    /* ================= ENTER ================= */
    skillInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addSkill(this.value);
            this.value = '';
        }
    });

    /* ================= RENDER CHIP MODAL ================= */
    function renderPreview() {
        skillPreview.innerHTML = '';
        skills.forEach((skill, index) => {
            skillPreview.innerHTML += `
                <span class="skill-chip">
                    ${skill}
                    <button type="button" onclick="removeSkill(${index})">&times;</button>
                </span>
            `;
        });
    }

    window.removeSkill = function (index) {
        skills.splice(index, 1);
        renderPreview();
    };

    /* ================= SIMPAN KE BACKEND ================= */
    window.saveSkills = async function () {

        // kalau user belum tekan enter
        if (skillInput.value.trim()) {
            addSkill(skillInput.value);
            skillInput.value = '';
        }

        if (!skills.length) {
            alert('Tambahkan minimal 1 skill');
            return;
        }

        for (const skill of skills) {
            await fetch('/pelamar/profile/skills', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken(),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    nama_skill: skill
                })
            });
        }

        // refresh agar sinkron DB
        location.reload();
    };

    /* ================= RESET MODAL ================= */
    const modalSkills = document.getElementById('modalSkills');
    modalSkills.addEventListener('show.bs.modal', () => {
        skills = [];
        renderPreview();
    });

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

document.addEventListener('DOMContentLoaded', () => {

    const input   = document.getElementById('resumeInput');
    const preview = document.getElementById('resumePreview');
    const frame   = document.getElementById('resumeFrame');

    if (!input) return;

    input.addEventListener('change', () => {
        const file = input.files[0];
        if (!file) return;

        // VALIDASI
        if (file.type !== 'application/pdf') {
            alert('Resume harus PDF');
            resetInput();
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert('Maksimal 5 MB');
            resetInput();
            return;
        }

        // AUTO CLEAR PREVIEW LAMA
        frame.src = '';
        preview.style.display = 'block';

        frame.src = URL.createObjectURL(file);
    });

    function resetInput() {
        input.value = '';
        preview.style.display = 'none';
        frame.src = '';
    }

    window.saveResume = function () {

        if (!input.files.length) {
            alert('Pilih file terlebih dahulu');
            return;
        }

        const formData = new FormData();
        formData.append('resume', input.files[0]);

        fetch('/profile/resume', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async res => {
            if (!res.ok) throw new Error();

            const data = await res.json();

            // UPDATE UI TANPA RELOAD
            renderResume(data);

            resetInput();
            bootstrap.Modal.getInstance(
                document.getElementById('modalResume')
            ).hide();
        })
        .catch(() => alert('Gagal upload resume'));
    };

    window.deleteResume = function () {

        if (!confirm('Yakin hapus resume?')) return;

        fetch('/profile/resume', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Accept': 'application/json'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error();

            document.getElementById('resumeOutput').innerHTML =
                `<span id="resumeEmpty">Belum ada resume diunggah</span>`;

            preview.style.display = 'none';
            frame.src = '';
        })
        .catch(() => alert('Gagal hapus resume'));
    };

    function renderResume(data) {
        document.getElementById('resumeOutput').innerHTML = `
            <div class="d-flex align-items-center justify-content-between">
                <a href="${data.url}"
                   target="_blank"
                   class="text-primary fw-semibold">
                    <i class="bi bi-file-earmark-pdf me-1"></i>
                    ${data.file_name}
                </a>

                <button class="btn btn-sm btn-light text-danger"
                        onclick="deleteResume()">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
    }
});

});

