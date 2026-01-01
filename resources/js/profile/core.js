document.addEventListener('DOMContentLoaded', () => {

    /* ================= CSRF ================= */
    function csrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    /* ================= DATA DIRI ================= */
    const form = document.getElementById('formDataDiri');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            fetch('/pelamar/profile/data-diri', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken()
                },
                body: new FormData(this)
            })
            .then(res => {
                if (!res.ok) throw new Error();
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
    }

    /* ================= FOTO PROFIL ================= */
    const photoInput   = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    const btnRemove    = document.getElementById('btnRemovePhoto');
    const removeInput  = document.getElementById('removePhoto');

    if (photoInput && photoPreview && removeInput) {
        photoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = e => photoPreview.src = e.target.result;
            reader.readAsDataURL(file);

            removeInput.value = 0;
        });
    }

    if (btnRemove && photoPreview && photoInput && removeInput) {
        btnRemove.addEventListener('click', () => {
            if (!confirm('Hapus foto profil?')) return;

            photoPreview.src = '/images/default-avatar.png';
            photoInput.value = '';
            removeInput.value = 1;
        });
    }

    /* ================= TENTANG SAYA ================= */
    const textarea = document.getElementById('tentangSayaInput');
    const counter  = document.getElementById('charCount');
    const output   = document.getElementById('tentangSayaOutput');

    function updateCounter() {
        if (!textarea || !counter) return;
        counter.innerText = textarea.value.length;
    }

    if (textarea) {
        textarea.addEventListener('input', updateCounter);
        updateCounter();
    }

    window.saveTentangSaya = function () {
        if (!textarea || !output) return;

        fetch('/pelamar/profile/tentang-saya', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                tentang_saya: textarea.value
            })
        })
        .then(res => {
            if (!res.ok) throw new Error();
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

});
