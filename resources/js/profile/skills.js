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
    return document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content');
}

window.deleteSkill = function (id) {

    if (!confirm('Hapus skill ini?')) return;

    fetch(`/pelamar/profile/skills/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken(),
            'Accept': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error();

        // HAPUS CHIP
        const el = document.getElementById(`skill-${id}`);
        if (el) el.remove();

        // CEK JIKA SUDAH TIDAK ADA SKILL
        const skillsList = document.getElementById('skillsList');
        const remainingSkills = skillsList.querySelectorAll('.skill-chip');

        if (remainingSkills.length === 0) {
            skillsList.innerHTML = `
                <span class="skill-chip readonly">
                    Belum ada skill
                </span>
            `;
        }
    })
    .catch(() => {
        alert('Gagal menghapus skill');
    });
};



});

