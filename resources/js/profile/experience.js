let experienceCounter = 2;

function addExperience() {

    const editId   = document.getElementById('experienceEditId').value;
    const position = document.getElementById('expPosition').value;
    const company  = document.getElementById('expCompany').value;
    const start    = document.getElementById('expStart').value;
    const end      = document.getElementById('expEnd').value || 'Sekarang';
    const desc     = document.getElementById('expDescription').value;

    if (!position || !company || !start) {
        alert('Posisi, perusahaan, dan tanggal mulai wajib diisi.');
        return;
    }

    const list = document.getElementById('pengalamanList');

    // ================= UPDATE =================
    if (editId) {
        const item = document.querySelector(`[data-id="${editId}"]`);

        item.querySelector('.experience-position').innerText = position;
        item.querySelector('.experience-company').innerText =
            `${company} • ${start} – ${end}`;
        item.querySelector('.experience-description').innerText = desc;

        resetExperienceForm();
        return;
    }

    // ================= ADD BARU =================
    const html = `
        <div class="experience-item d-flex gap-3 mb-4" data-id="${experienceCounter}">
            <div class="timeline-dot"></div>

            <div class="flex-grow-1">

                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="fw-bold mb-1 experience-position">${position}</h6>
                        <div class="text-muted small mb-1 experience-company">
                            ${company} • ${start} – ${end}
                        </div>
                    </div>

                    <div class="experience-actions position-relative">
                        <button class="btn btn-sm btn-light"
                                onclick="toggleMenu(this)">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>

                        <div class="experience-menu shadow">
                            <button onclick="editExperience(this)">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </button>
                            <button class="text-danger"
                                    onclick="deleteExperience(this)">
                                <i class="bi bi-trash me-2"></i>Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <p class="text-muted small mb-0 experience-description">
                    ${desc}
                </p>

            </div>
        </div>
    `;

    if (list.querySelector('p')) {
        list.innerHTML = '';
    }

    list.insertAdjacentHTML('beforeend', html);
    experienceCounter++;

    resetExperienceForm();
}

function editExperience(button) {
    button.closest('.experience-menu').style.display = 'none';
    const item = button.closest('.experience-item');

    const position = item.querySelector('.experience-position').innerText;
    const company  = item.querySelector('.experience-company').innerText;
    const desc     = item.querySelector('.experience-description').innerText;

    document.getElementById('experienceEditId').value =
        item.dataset.id;
    document.getElementById('expPosition').value = position;
    document.getElementById('expCompany').value  = company.split(' • ')[0];
    document.getElementById('expDescription').value = desc;

    new bootstrap.Modal(
        document.getElementById('modalPengalamanKerja')
    ).show();
}

function deleteExperience(button) {
    if (!confirm('Yakin hapus pengalaman ini?')) return;
    button.closest('.experience-menu').style.display = 'none';
    button.closest('.experience-item').remove();
}

function toggleMenu(button) {
    const menu = button.nextElementSibling;

    // tutup semua menu lain
    document.querySelectorAll('.experience-menu').forEach(el => {
        if (el !== menu) el.style.display = 'none';
    });

    menu.style.display =
        menu.style.display === 'block' ? 'none' : 'block';
}

function resetExperienceForm() {
    document.getElementById('experienceEditId').value = '';
    document.getElementById('expPosition').value = '';
    document.getElementById('expCompany').value = '';
    document.getElementById('expStart').value = '';
    document.getElementById('expEnd').value = '';
    document.getElementById('expDescription').value = '';
}

document.addEventListener('click', function (e) {
    if (!e.target.closest('.experience-actions')) {
        document.querySelectorAll('.experience-menu').forEach(el => {
            el.style.display = 'none';
        });
    }
});