document.addEventListener('DOMContentLoaded', function () {

    const skillInput   = document.getElementById('skillInput');
    const skillPreview = document.getElementById('skillPreview');
    const skillsList   = document.getElementById('skillsList');

    let skills = [];

    /* ================= TAMBAH SKILL ================= */
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

    /* ================= RENDER CHIP DI MODAL ================= */
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

    /* ================= HAPUS ================= */
    window.removeSkill = function (index) {
        skills.splice(index, 1);
        renderPreview();
    }

    /* ================= SIMPAN ================= */
    window.saveSkills = function () {

        // 👉 JIKA USER KETIK TAPI BELUM ENTER
        if (skillInput.value.trim()) {
            addSkill(skillInput.value);
            skillInput.value = '';
        }

        skillsList.innerHTML = '';

        if (!skills.length) {
            skillsList.innerHTML = `
                <span class="skill-chip readonly">Belum ada skill</span>
            `;
            return;
        }

        skills.forEach(skill => {
            skillsList.innerHTML += `
                <span class="skill-chip readonly">${skill}</span>
            `;
        });
    };

    /* ================= BUKA MODAL ================= */
    const modalSkills = document.getElementById('modalSkills');
    modalSkills.addEventListener('show.bs.modal', renderPreview);

});