console.log('skills.js loaded');

/* ===============================
   CSRF
================================ */
function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

/* ===============================
   DELETE SKILL (GLOBAL)
   DIPAKAI DI HALAMAN PROFILE
================================ */
window.deleteSkill = async function (id) {

    if (!confirm('Hapus skill ini?')) return;

    try {
        const res = await fetch(`/pelamar/profile/skills/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (!res.ok) {
            alert(data.message || 'Gagal menghapus skill');
            return;
        }

        // hapus langsung dari DOM
        const el = document.getElementById(`skill-${id}`);
        if (el) el.remove();

    } catch (err) {
        console.error(err);
        alert('Terjadi kesalahan');
    }
};

/* ===============================
   TAMBAH SKILL (MODAL)
================================ */
document.addEventListener('DOMContentLoaded', () => {

    const skillInput   = document.getElementById('skillInput');
    const skillPreview = document.getElementById('skillPreview');
    const modalSkills  = document.getElementById('modalSkills');

    // halaman tanpa modal → STOP DI SINI
    if (!skillInput || !skillPreview || !modalSkills) return;

    let skills = [];

    /* ================= TAMBAH ================= */
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
    skillInput.addEventListener('keydown', e => {
        if (e.key === 'Enter') {
            e.preventDefault();
            addSkill(skillInput.value);
            skillInput.value = '';
        }
    });

    /* ================= RENDER ================= */
    function renderPreview() {
        skillPreview.innerHTML = '';

        skills.forEach((skill, index) => {
            skillPreview.insertAdjacentHTML('beforeend', `
                <span class="skill-chip">
                    ${skill}
                    <button type="button"
                            class="btn btn-sm"
                            onclick="removeSkill(${index})">
                        &times;
                    </button>
                </span>
            `);
        });
    }

    /* ================= REMOVE PREVIEW ================= */
    window.removeSkill = function (index) {
        skills.splice(index, 1);
        renderPreview();
    };

    /* ================= SIMPAN ================= */
    window.saveSkills = async function () {

        if (skillInput.value.trim()) {
            addSkill(skillInput.value);
            skillInput.value = '';
        }

        if (!skills.length) {
            alert('Tambahkan minimal 1 skill');
            return;
        }

        try {
            for (const skill of skills) {
                const res = await fetch('/pelamar/profile/skills', {
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

                if (!res.ok) throw new Error();
            }

            location.reload();

        } catch (err) {
            console.error(err);
            alert('Gagal menyimpan skill');
        }
    };

    /* ================= RESET MODAL ================= */
    modalSkills.addEventListener('show.bs.modal', () => {
        skills = [];
        skillInput.value = '';
        renderPreview();
    });

});
