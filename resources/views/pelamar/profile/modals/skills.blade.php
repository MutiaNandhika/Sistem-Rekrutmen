{{-- ================= MODAL SKILLS ================= --}}
<div class="modal fade" id="modalSkills" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Skills</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <p class="text-muted small">
                    Pilih 3–10 skill terkuat kamu
                </p>

                <input id="skillInput"
                       class="form-control mb-3"
                       placeholder="Ketik skill lalu tekan Enter">

                <div id="skillPreview"
                     class="d-flex flex-wrap gap-2"></div>
            </div>

            <div class="modal-footer border-0">
                <button class="btn btn-light"
                        data-bs-dismiss="modal">
                    Batal
                </button>

                <button class="btn btn-primary" 
                        onclick="saveSkills()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>
            </div>

        </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    let skills = [];

    const input = document.getElementById('skillInput');
    const preview = document.getElementById('skillPreview');

    if (!input || !preview) return;

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();

            const value = input.value.trim();
            if (!value || skills.includes(value)) return;

            skills.push(value);
            renderSkills();
            input.value = '';
        }
    });

    function renderSkills() {
        preview.innerHTML = '';

        skills.forEach((skill, index) => {
            const chip = document.createElement('span');
            chip.className = 'skill-chip';
            chip.innerHTML = `
                ${skill}
                <button type="button" onclick="removeSkill(${index})">×</button>
            `;
            preview.appendChild(chip);
        });
    }

    window.removeSkill = function(index) {
        skills.splice(index, 1);
        renderSkills();
    }

    console.log(skills);

    function saveSkills() {
    const lastValue = input.value.trim();

    // MASUKKAN SKILL TERAKHIR JIKA ADA
    if (lastValue && !skills.includes(lastValue)) {
        skills.push(lastValue);
    }

    if (skills.length === 0) {
        alert('Masukkan minimal 1 skill');
        return;
    }

    const requests = skills.map(skill => {
        return fetch('/pelamar/profile/skills', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ nama_skill: skill })
        });
    });

    Promise.all(requests)
        .then(() => location.reload())
        .catch(() => alert('Gagal menyimpan skill'));
}


});
</script>
