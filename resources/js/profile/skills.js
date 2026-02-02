/* =========================================
   SKILLS.JS – FINAL VERSION
========================================= */

/* ===== CSRF TOKEN ===== */
function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

document.addEventListener('DOMContentLoaded', () => {

    console.log('skills.js FINAL LOADED');

    const select  = document.getElementById('skillSelect');
    const input   = document.getElementById('customSkill');
    const preview = document.getElementById('skillPreview');
    const modal   = document.getElementById('modalSkills');
    const btnSave = document.getElementById('btnSaveSkills');

    if (!select || !input || !preview || !btnSave) return;

    let skills = [];

    /* =========================
       TAMBAH DARI DROPDOWN
    ========================= */
    select.addEventListener('change', () => {
        const id = select.value;
        const text = select.options[select.selectedIndex].text;

        if (!id) return;

        addSkill({
            skill_id: parseInt(id),
            text: text
        });

        select.value = '';
    });

    /* =========================
       TAMBAH MANUAL (ENTER)
    ========================= */
    input.addEventListener('keydown', e => {
        if (e.key === 'Enter') {
            e.preventDefault();
            const value = input.value.trim();
            if (!value) return;

            addSkill({
                nama_skill: value,
                text: value
            });

            input.value = '';
        }
    });

    /* =========================
       ADD SKILL (INTERNAL)
    ========================= */
    function addSkill(skill) {

        // Bersihkan konflik
        if (skill.skill_id) delete skill.nama_skill;
        if (skill.nama_skill) delete skill.skill_id;

        // Batas 10
        if (skills.length >= 10) {
            showAlert({
                icon: 'warning',
                title: 'Batas Skill',
                text: 'Maksimal 10 skill'
            });
            return;
        }

        // Anti duplikat (case-insensitive)
        if (skills.find(s => s.text.toLowerCase() === skill.text.toLowerCase())) {
            return;
        }

        skills.push(skill);
        render();
    }

    /* =========================
       RENDER PREVIEW
    ========================= */
    function render() {
        preview.innerHTML = '';

        skills.forEach((s, i) => {
            preview.insertAdjacentHTML('beforeend', `
                <span class="skill-chip">
                    ${s.text}
                    <button type="button" onclick="removeSkill(${i})">&times;</button>
                </span>
            `);
        });
    }

    window.removeSkill = index => {
        skills.splice(index, 1);
        render();
    };

    /* =========================
       SIMPAN KE SERVER
    ========================= */
    btnSave.addEventListener('click', async () => {

        if (!skills.length) {
            showAlert({
                icon: 'warning',
                title: 'Skill kosong',
                text: 'Tambahkan minimal 1 skill'
            });
            return;
        }

        try {
            // 🔥 kirim satu per satu (AMAN & SIMPLE)
            for (const skill of skills) {
                const res = await fetch('/pelamar/profile/skills', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken(),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(skill)
                });

                if (!res.ok) {
                    throw new Error('Gagal simpan skill');
                }
            }

            showAlert({
                icon: 'success',
                title: 'Berhasil',
                text: 'Skill berhasil disimpan'
            });

            setTimeout(() => {
                location.reload();
            }, 700);

        } catch (err) {
            console.error(err);
            showAlert({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan saat menyimpan skill'
            });
        }
    });

    /* =========================
       RESET SAAT MODAL DIBUKA
    ========================= */
    modal.addEventListener('show.bs.modal', () => {
        skills = [];
        render();
        input.value = '';
        select.value = '';
    });
});

window.deleteSkill = async function (id) {

    const result = await Swal.fire({
        title: 'Hapus skill?',
        text: 'Skill ini akan dihapus dari profil kamu',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
    });

    if (!result.isConfirmed) return;

    try {
        const res = await fetch(`/pelamar/profile/skills/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Accept': 'application/json'
            }
        });

        if (!res.ok) {
            throw new Error('Gagal hapus skill');
        }

        // hapus dari UI
        const el = document.getElementById(`skill-${id}`);
        if (el) el.remove();

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Skill berhasil dihapus',
            timer: 1500,
            showConfirmButton: false
        });

    } catch (err) {
        console.error(err);
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Skill gagal dihapus'
        });
    }
};

