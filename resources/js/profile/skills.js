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
================================ */
window.deleteSkill = async function (id) {

    if (typeof Swal === 'undefined') {
        if (!confirm('Hapus skill ini?')) return;
        doDelete();
        return;
    }

    Swal.fire({
        title: 'Yakin?',
        text: 'Skill akan dihapus',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then(result => {
        if (!result.isConfirmed) return;
        doDelete();
    });

    async function doDelete() {
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
                showAlert({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Gagal menghapus skill',
                    timer: null
                });
                return;
            }

            // hapus langsung dari DOM
            const el = document.getElementById(`skill-${id}`);
            if (el) el.remove();

            showAlert({
                icon: 'success',
                title: 'Berhasil',
                text: 'Skill berhasil dihapus'
            });

        } catch (err) {
            console.error(err);
            showAlert({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan',
                timer: null
            });
        }
    }
};

/* ===============================
   TAMBAH SKILL (MODAL)
================================ */
document.addEventListener('DOMContentLoaded', () => {

    const skillInput   = document.getElementById('skillInput');
    const skillPreview = document.getElementById('skillPreview');
    const modalSkills  = document.getElementById('modalSkills');

    // halaman tanpa modal → STOP
    if (!skillInput || !skillPreview || !modalSkills) return;

    let skills = [];

    /* ================= TAMBAH ================= */
    function addSkill(value) {
        value = value.trim();
        if (!value) return;
        if (skills.includes(value)) return;

        if (skills.length >= 10) {
            showAlert({
                icon: 'warning',
                title: 'Batas Skill',
                text: 'Maksimal 10 skill',
                timer: null
            });
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
            showAlert({
                icon: 'warning',
                title: 'Periksa Data',
                text: 'Tambahkan minimal 1 skill',
                timer: null
            });
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

            showAlert({
                icon: 'success',
                title: 'Berhasil',
                text: 'Skill berhasil disimpan'
            });

            // reload tetap dipertahankan (sesuai flow lama)
            setTimeout(() => {
                location.reload();
            }, 800);

        } catch (err) {
            console.error(err);
            showAlert({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal menyimpan skill',
                timer: null
            });
        }
    };

    /* ================= RESET MODAL ================= */
    modalSkills.addEventListener('show.bs.modal', () => {
        skills = [];
        skillInput.value = '';
        renderPreview();
    });

});
