let certificates = [];
let certificateCounter = 1;

function saveCertificate() {

    const editId   = document.getElementById('certificateEditId').value;
    const name     = document.getElementById('certName').value.trim();
    const issuer   = document.getElementById('certIssuer').value.trim();
    const issueM   = document.getElementById('certIssueMonth').value;
    const issueY   = document.getElementById('certIssueYear').value;
    const expireM  = document.getElementById('certExpireMonth').value;
    const expireY  = document.getElementById('certExpireYear').value;
    const noExpire = document.getElementById('certNoExpire').checked;
    const desc     = document.getElementById('certDesc').value.trim();

    if (!name || !issuer || !issueM || !issueY) {
        alert('Lengkapi data wajib');
        return;
    }

    const period = noExpire
        ? `${issueM} ${issueY} • Tidak kedaluwarsa`
        : `${issueM} ${issueY} – ${expireM} ${expireY}`;

    if (editId) {
        const item = certificates.find(c => c.id == editId);
        item.name = name;
        item.issuer = issuer;
        item.period = period;
        item.desc = desc;
    } else {
        certificates.push({
            id: certificateCounter++,
            name,
            issuer,
            period,
            desc
        });
    }

    resetCertificateForm();
    renderCertificates();
}

/* ========== RENDER LIST ========== */
function renderCertificates() {

    const list = document.getElementById('sertifikatList');
    list.innerHTML = '';

    if (!certificates.length) {
        list.innerHTML = `
            <p class="text-muted small">
                Beritahu prestasimu dengan menambahkan sertifikat di sini.
            </p>`;
        return;
    }

    certificates.forEach(item => {
        list.innerHTML += `
            <div class="certificate-item d-flex justify-content-between mb-3">
                <div>
                    <div class="fw-semibold">${item.name}</div>
                    <div class="text-muted small">
                        ${item.issuer} • ${item.period}
                    </div>
                    ${item.desc
                        ? `<div class="text-muted small mt-1">${item.desc}</div>`
                        : ''
                    }
                </div>

                <div class="certificate-actions position-relative">
                    <button class="btn btn-sm btn-light"
                            onclick="toggleCertificateMenu(this)">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>

                    <div class="certificate-menu shadow">
                        <button onclick="editCertificate(${item.id})">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </button>
                        <button class="text-danger"
                                onclick="deleteCertificate(${item.id})">
                            <i class="bi bi-trash me-2"></i>Hapus
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
}

/* ========== TOGGLE MENU ========== */
function toggleCertificateMenu(button) {

    const menu = button.nextElementSibling;

    document.querySelectorAll('.certificate-menu').forEach(el => {
        if (el !== menu) el.style.display = 'none';
    });

    menu.style.display =
        menu.style.display === 'block' ? 'none' : 'block';
}

document.addEventListener('click', function (e) {
    if (!e.target.closest('.certificate-actions')) {
        document.querySelectorAll('.certificate-menu').forEach(el => {
            el.style.display = 'none';
        });
    }
});

/* ========== EDIT ========== */
function editCertificate(id) {

    const item = certificates.find(c => c.id === id);

    document.getElementById('certificateEditId').value = item.id;
    document.getElementById('certName').value = item.name;
    document.getElementById('certIssuer').value = item.issuer;
    document.getElementById('certDesc').value = item.desc;

    new bootstrap.Modal(
        document.getElementById('modalSertifikat')
    ).show();
}

/* ========== HAPUS ========== */
function deleteCertificate(id) {
    if (!confirm('Yakin hapus sertifikat ini?')) return;

    certificates = certificates.filter(c => c.id !== id);
    renderCertificates();
}

/* ========== RESET FORM ========== */
function resetCertificateForm() {
    document.getElementById('certificateEditId').value = '';
    document.getElementById('certName').value = '';
    document.getElementById('certIssuer').value = '';
    document.getElementById('certIssueMonth').value = '';
    document.getElementById('certIssueYear').value = '';
    document.getElementById('certExpireMonth').value = '';
    document.getElementById('certExpireYear').value = '';
    document.getElementById('certNoExpire').checked = false;
    document.getElementById('certDesc').value = '';
}
