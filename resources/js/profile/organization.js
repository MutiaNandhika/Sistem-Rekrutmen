function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

window.saveOrg = function () {

    const id = document.getElementById('orgEditId').value;

    const payload = {
        nama_organisasi: document.getElementById('orgName').value.trim(),
        posisi: document.getElementById('orgRole').value.trim(),
        mulai_bulan: document.getElementById('orgStartMonth').value,
        mulai_tahun: document.getElementById('orgStartYear').value,
        selesai_bulan: document.getElementById('orgEndMonth').value,
        selesai_tahun: document.getElementById('orgEndYear').value,
        masih_aktif: document.getElementById('orgOngoing').checked,
        informasi_tambahan: document.getElementById('orgDesc').value.trim(),
    };

    if (!payload.nama_organisasi || !payload.posisi || !payload.mulai_bulan || !payload.mulai_tahun) {
        alert('Lengkapi data wajib');
        return;
    }

    const BASE_URL = '/pelamar/profile/organizations';
    const url = id ? `${BASE_URL}/${id}` : BASE_URL;
    const method = id ? 'PUT' : 'POST';

    fetch(url, {
        method,
        headers: {
            'X-CSRF-TOKEN': csrfToken(),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(() => location.reload())
    .catch(() => alert('Request gagal'));
};

window.editOrganization = function (id, org) {

    // set ID edit
    document.getElementById('orgEditId').value = id;

    // isi field utama
    document.getElementById('orgName').value = org.nama_organisasi;
    document.getElementById('orgRole').value = org.posisi;
    document.getElementById('orgDesc').value = org.informasi_tambahan ?? '';

    // isi tanggal mulai
    document.getElementById('orgStartMonth').value = org.mulai_bulan;
    document.getElementById('orgStartYear').value  = org.mulai_tahun;

    // checkbox masih aktif
    document.getElementById('orgOngoing').checked = !!org.masih_aktif;

    // isi tanggal selesai (kalau tidak masih aktif)
    if (!org.masih_aktif) {
        document.getElementById('orgEndMonth').value = org.selesai_bulan;
        document.getElementById('orgEndYear').value  = org.selesai_tahun;
    } else {
        document.getElementById('orgEndMonth').value = '';
        document.getElementById('orgEndYear').value  = '';
    }

    // buka modal
    new bootstrap.Modal(
        document.getElementById('modalOrganisasi')
    ).show();
};


window.deleteOrganization = function (id) {

    if (!confirm('Yakin ingin menghapus data ini?')) return;

    fetch(`/pelamar/profile/organizations/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken(),
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(() => {
        document.getElementById(`organization-${id}`)?.remove();
    })
    .catch(() => alert('Gagal menghapus data'));
};
