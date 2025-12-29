let awards = [];
let awardCounter = 1;

function saveAward() {

    const editId = document.getElementById('awardEditId').value;
    const title  = document.getElementById('awardTitle').value.trim();
    const role   = document.getElementById('awardRole').value.trim();
    const year   = document.getElementById('awardYear').value;
    const desc   = document.getElementById('awardDesc').value.trim();

    if (!title || !role || !year) {
        alert('Lengkapi data wajib');
        return;
    }

    if (editId) {
        const item = awards.find(a => a.id == editId);
        item.title = title;
        item.role  = role;
        item.year  = year;
        item.desc  = desc;
    } else {
        awards.push({
            id: awardCounter++,
            title, role, year, desc
        });
    }

    resetAwardForm();
    renderAwards();
}

function renderAwards() {

    const list = document.getElementById('penghargaanList');
    list.innerHTML = '';

    if (!awards.length) {
        list.innerHTML = `
            <p class="text-muted small">
                Beritahu prestasimu dengan menambahkan penghargaan di sini.
            </p>`;
        return;
    }

    awards.forEach(item => {
        list.innerHTML += `
            <div class="award-item d-flex justify-content-between align-items-start mb-3">
                <div>
                    <div class="fw-semibold">${item.title}</div>
                    <div class="text-muted small">
                        ${item.role} • ${item.year}
                    </div>
                    ${item.desc
                        ? `<div class="text-muted small mt-1">${item.desc}</div>`
                        : ''
                    }
                </div>

                <div class="award-actions position-relative">
                    <button class="btn btn-sm btn-light"
                            onclick="toggleAwardMenu(this)">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>

                    <div class="award-menu shadow">
                        <button onclick="editAward(${item.id})">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </button>
                        <button class="text-danger"
                                onclick="deleteAward(${item.id})">
                            <i class="bi bi-trash me-2"></i>Hapus
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
}

function editAward(id) {

    const item = awards.find(a => a.id === id);

    document.getElementById('awardEditId').value = item.id;
    document.getElementById('awardTitle').value  = item.title;
    document.getElementById('awardRole').value   = item.role;
    document.getElementById('awardYear').value   = item.year;
    document.getElementById('awardDesc').value   = item.desc;

    new bootstrap.Modal(
        document.getElementById('modalPenghargaan')
    ).show();
}

function deleteAward(id) {
    if (!confirm('Yakin hapus penghargaan ini?')) return;

    awards = awards.filter(a => a.id !== id);
    renderAwards();
}

function resetAwardForm() {
    document.getElementById('awardEditId').value = '';
    document.getElementById('awardTitle').value  = '';
    document.getElementById('awardRole').value   = '';
    document.getElementById('awardYear').value   = '';
    document.getElementById('awardDesc').value   = '';
}

function toggleAwardMenu(button) {
    const menu = button.nextElementSibling;

    document.querySelectorAll('.award-menu').forEach(el => {
        if (el !== menu) el.style.display = 'none';
    });

    menu.style.display =
        menu.style.display === 'block' ? 'none' : 'block';
}

document.addEventListener('click', function (e) {
    if (!e.target.closest('.award-actions')) {
        document.querySelectorAll('.award-menu').forEach(el => {
            el.style.display = 'none';
        });
    }
});

