let educationCounter  = 2;

function addEducation() {

    const editId = document.getElementById('educationEditId').value;
    const school = document.getElementById('eduSchool').value;
    const major  = document.getElementById('eduMajor').value;
    const start  = document.getElementById('eduStart').value;
    const end    = document.getElementById('eduEnd').value;

    if (!school || !major || !start || !end) {
        alert('Lengkapi data pendidikan.');
        return;
    }

    const list = document.getElementById('pendidikanList');

    // ===== UPDATE =====
    if (editId) {
        const item = document.querySelector(`[data-id="${editId}"]`);

        item.querySelector('.education-school').innerText = school;
        item.querySelector('.education-major').innerText  = major;
        item.querySelector('.education-period').innerText =
            `${start} – ${end}`;

        resetEducationForm();
        return;
    }

    // ===== ADD BARU =====
    const html = `
        <div class="education-item d-flex justify-content-between mb-3"
             data-id="${educationCounter}">
            <div>
                <h6 class="fw-bold mb-1 education-school">${school}</h6>
                <div class="text-muted small education-major">${major}</div>
                <div class="text-muted small education-period">
                    ${start} – ${end}
                </div>
            </div>

            <div class="education-actions position-relative">
                <button class="btn btn-sm btn-light"
                        onclick="toggleEducationMenu(this)">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>

                <div class="education-menu shadow">
                    <button onclick="editEducation(this)">
                        <i class="bi bi-pencil me-2"></i>Edit
                    </button>
                    <button class="text-danger"
                            onclick="deleteEducation(this)">
                        <i class="bi bi-trash me-2"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    `;

    if (list.querySelector('p')) {
        list.innerHTML = '';
    }

    list.insertAdjacentHTML('beforeend', html);
    educationCounter++;

    resetEducationForm();
}

function editEducation(button) {
    const item = button.closest('.education-item');

    document.getElementById('educationEditId').value =
        item.dataset.id;

    document.getElementById('eduSchool').value =
        item.querySelector('.education-school').innerText;

    document.getElementById('eduMajor').value =
        item.querySelector('.education-major').innerText;

    const period = item
        .querySelector('.education-period')
        .innerText.split(' – ');

    document.getElementById('eduStart').value = period[0];
    document.getElementById('eduEnd').value   = period[1];

    new bootstrap.Modal(
        document.getElementById('modalPendidikan')
    ).show();

    button.closest('.education-menu').style.display = 'none';
}

function deleteEducation(button) {
    if (!confirm('Yakin hapus pendidikan ini?')) return;

    button.closest('.education-item').remove();
}

function resetEducationForm() {
    document.getElementById('educationEditId').value = '';
    document.getElementById('eduSchool').value = '';
    document.getElementById('eduMajor').value = '';
    document.getElementById('eduStart').value = '';
    document.getElementById('eduEnd').value = '';
}

function toggleEducationMenu(button) {
    const menu = button.nextElementSibling;

    document.querySelectorAll('.education-menu').forEach(el => {
        if (el !== menu) el.style.display = 'none';
    });

    menu.style.display =
        menu.style.display === 'block' ? 'none' : 'block';
}

document.addEventListener('click', function (e) {
    if (!e.target.closest('.education-actions')) {
        document.querySelectorAll('.education-menu').forEach(el => {
            el.style.display = 'none';
        });
    }
});