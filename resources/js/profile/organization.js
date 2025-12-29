let orgs = [];
let orgCounter = 1;

/* ================= SIMPAN / UPDATE ================= */
function saveOrg() {

    const editId = document.getElementById('orgEditId').value;
    const name   = document.getElementById('orgName').value.trim();
    const role   = document.getElementById('orgRole').value.trim();

    const sm = document.getElementById('orgStartMonth').value;
    const sy = document.getElementById('orgStartYear').value;
    const em = document.getElementById('orgEndMonth').value;
    const ey = document.getElementById('orgEndYear').value;

    const ongoing = document.getElementById('orgOngoing').checked;
    const desc    = document.getElementById('orgDesc').value.trim();

    if (!name || !role || !sm || !sy) {
        alert('Lengkapi data wajib');
        return;
    }

    let period = `${sm} ${sy} – `;
    period += ongoing ? 'Sekarang' : `${em} ${ey}`;

    if (editId) {
        const item = orgs.find(o => o.id == editId);
        item.name   = name;
        item.role   = role;
        item.period = period;
        item.desc   = desc;
    } else {
        orgs.push({
            id: orgCounter++,
            name,
            role,
            period,
            desc
        });
    }

    resetOrgForm();
    renderOrgs();
}

/* ================= RENDER LIST ================= */
function renderOrgs() {

    const list = document.getElementById('organisasiList');
    list.innerHTML = '';

    if (!orgs.length) {
        list.innerHTML = `
            <p class="text-muted small">
                Adakah kegiatan ekstrakurikuler atau relawan yang ingin kamu tampilkan?
            </p>`;
        return;
    }

    orgs.forEach(item => {
        list.innerHTML += `
            <div class="org-item d-flex justify-content-between mb-3">

                <div>
                    <div class="fw-semibold">${item.name}</div>
                    <div class="text-muted small">
                        ${item.role} • ${item.period}
                    </div>
                    ${item.desc
                        ? `<div class="text-muted small mt-1">${item.desc}</div>`
                        : ''
                    }
                </div>

                <div class="org-actions position-relative">
                    <button class="btn btn-sm btn-light"
                            onclick="toggleOrgMenu(this)">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>

                    <div class="org-menu shadow">
                        <button onclick="editOrg(${item.id})">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </button>
                        <button class="text-danger"
                                onclick="deleteOrg(${item.id})">
                            <i class="bi bi-trash me-2"></i>Hapus
                        </button>
                    </div>
                </div>

            </div>
        `;
    });
}

/* ================= TOGGLE MENU ================= */
function toggleOrgMenu(button) {

    const menu = button.nextElementSibling;

    // tutup menu lain
    document.querySelectorAll('.org-menu').forEach(el => {
        if (el !== menu) el.style.display = 'none';
    });

    menu.style.display =
        menu.style.display === 'block' ? 'none' : 'block';
}

/* ================= KLIK DI LUAR ================= */
document.addEventListener('click', function (e) {
    if (!e.target.closest('.org-actions')) {
        document.querySelectorAll('.org-menu').forEach(el => {
            el.style.display = 'none';
        });
    }
});

/* ================= EDIT ================= */
function editOrg(id) {

    const item = orgs.find(o => o.id === id);

    document.getElementById('orgEditId').value = item.id;
    document.getElementById('orgName').value   = item.name;
    document.getElementById('orgRole').value   = item.role;
    document.getElementById('orgDesc').value   = item.desc;

    const period = item.period.split(' – ');
    const start  = period[0].split(' ');
    document.getElementById('orgStartMonth').value = start[0];
    document.getElementById('orgStartYear').value  = start[1];

    if (period[1] === 'Sekarang') {
        document.getElementById('orgOngoing').checked = true;
    } else {
        const end = period[1].split(' ');
        document.getElementById('orgEndMonth').value = end[0];
        document.getElementById('orgEndYear').value  = end[1];
        document.getElementById('orgOngoing').checked = false;
    }

    new bootstrap.Modal(
        document.getElementById('modalOrganisasi')
    ).show();
}

/* ================= HAPUS ================= */
function deleteOrg(id) {
    if (!confirm('Yakin hapus pengalaman ini?')) return;

    orgs = orgs.filter(o => o.id !== id);
    renderOrgs();
}

/* ================= RESET FORM ================= */
function resetOrgForm() {
    document.getElementById('orgEditId').value = '';
    document.getElementById('orgName').value = '';
    document.getElementById('orgRole').value = '';
    document.getElementById('orgStartMonth').value = '';
    document.getElementById('orgStartYear').value = '';
    document.getElementById('orgEndMonth').value = '';
    document.getElementById('orgEndYear').value = '';
    document.getElementById('orgOngoing').checked = false;
    document.getElementById('orgDesc').value = '';
}