document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formDataDiri');
    if (!form) return;

    const csrf = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        fetch('/pelamar/profile/data-diri', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            body: new FormData(this)
        })
        .then(res => {
            if (!res.ok) throw new Error('Network error');
            return res.json();
        })
        .then(data => {
            alert(data.message);
            location.reload();
        })
        .catch(err => {
            console.error(err);
            alert('Gagal menyimpan data');
        });
    });

});

const photoInput   = document.getElementById('photoInput');
const photoPreview = document.getElementById('photoPreview');
const btnRemove    = document.getElementById('btnRemovePhoto');
const removeInput  = document.getElementById('removePhoto');

if (photoInput) {
    photoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = e => photoPreview.src = e.target.result;
        reader.readAsDataURL(file);

        removeInput.value = 0;
    });
}

if (btnRemove) {
    btnRemove.addEventListener('click', () => {
        if (!confirm('Hapus foto profil?')) return;
        photoPreview.src = '/images/default-avatar.png';
        photoInput.value = '';
        removeInput.value = 1;
    });
}

//Tentang Saya
function updateCounter() {
    const textarea = document.getElementById('tentangSayaInput');
    const counter  = document.getElementById('charCount');
    if (!textarea || !counter) return;
    counter.innerText = textarea.value.length;
}

window.saveTentangSaya = function () {

    const text = document.getElementById('tentangSayaInput').value;
    const output = document.getElementById('tentangSayaOutput');

    const csrf = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content');

    fetch('/pelamar/profile/tentang-saya', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            tentang_saya: text
        })
    })
    .then(res => {
        if (!res.ok) throw new Error('Network error');
        return res.json();
    })
    .then(data => {
        output.innerText = data.tentang_saya
            || 'Jelaskan secara singkat kelebihanmu sehingga perusahaan yakin untuk merekrutmu.';
    })
    .catch(err => {
        console.error(err);
        alert('Gagal menyimpan Tentang Saya');
    });
};

document.addEventListener('DOMContentLoaded', updateCounter);
