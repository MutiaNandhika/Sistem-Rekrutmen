document.addEventListener('DOMContentLoaded', () => {

    /* ================= GUARD ================= */
    const skillInput   = document.getElementById('skillInput');
    const skillPreview = document.getElementById('skillPreview');
    const skillsList   = document.getElementById('skillsList');
    const modalSkills  = document.getElementById('modalSkills');

    // halaman lain → STOP (INI KUNCI BIAR TIDAK CRASH)
    if (!skillInput || !skillPreview || !modalSkills) return;

    let skills = [];

    function csrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
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

    /* ================= ENTER INPUT ================= */
    skillInput.addEventListener('keydown', e => {
        if (e.key === 'Enter') {
            e.preventDefault();
            addSkill(skillInput.value);
            skillInput.value = '';
        }
    });

    /* ================= RENDER CHIP ================= */
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

    /* ================= REMOVE ================= */
    window.removeSkill = function (index) {
        skills.splice(index, 1);
        renderPreview();
    };

    /* ================= SIMPAN KE BACKEND ================= */
    window.saveSkills = async function () {

        // kalau user ngetik tapi belum tekan enter
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

        } catch (e) {
            console.error(e);
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
