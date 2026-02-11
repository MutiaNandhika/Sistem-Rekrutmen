document.addEventListener('DOMContentLoaded', () => {

    function csrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || '';
    }

    const DEFAULT_AVATAR = '/images/default-avatar.png';

    window.showAlert = ({ icon='success', title='Berhasil', text='', timer=2000 }) => {
        if (!window.Swal) return alert(text || title);
        Swal.fire({ icon, title, text, timer, showConfirmButton: !timer });
    };

    const form        = document.getElementById('formDataDiri');
    const modalEl     = document.getElementById('modalDataDiri');
    const avatar      = document.getElementById('profileAvatar');
    const preview     = document.getElementById('photoPreview');
    const removeEl    = document.getElementById('removePhoto');
    const photoInput  = document.getElementById('photoInput');
    const btnRemove   = document.getElementById('btnRemovePhoto');

    /* ================= SUBMIT DATA DIRI ================= */
    if (form) {
        form.addEventListener('submit', e => {
            e.preventDefault();

            fetch('/pelamar/profile/data-diri', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken() },
                body: new FormData(form)
            })
            .then(r => r.json())
            .then(data => {

                showAlert({ text: data.message });

                if (avatar && data.photo_url) {
                    avatar.src = data.photo_url + '?t=' + Date.now();
                }

                if (btnRemove && data.photo_url && data.photo_url !== DEFAULT_AVATAR) {
                    btnRemove.classList.remove('d-none');
                }

                if (modalEl && window.bootstrap) {
                    bootstrap.Modal.getInstance(modalEl)?.hide();
                }

                updateProfileText();
            })
            .catch(() => showAlert({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal menyimpan data',
                timer: null
            }));
        });
    }

    /* ================= UPDATE TEKS PROFIL ================= */
    function updateProfileText() {
        if (!form) return;

        const map = {
            name: 'data-profile-name',
            phone: 'data-profile-phone',
            location: 'data-profile-location',
            age: 'data-profile-age',
            last_education: 'data-profile-education',
            gender: 'data-profile-gender'
        };

        Object.keys(map).forEach(k => {
            const v = form.querySelector(`[name="${k}"]`)?.value || '-';
            document.querySelectorAll(`[${map[k]}]`)
                .forEach(el => el.innerText = v);
        });
    }

    /* ================= PREVIEW FOTO ================= */
    if (photoInput && preview) {
        photoInput.addEventListener('change', () => {
            const file = photoInput.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = e => preview.src = e.target.result;
            reader.readAsDataURL(file);

            if (removeEl) removeEl.value = 0;
        });
    }

    /* ================= HAPUS FOTO ================= */
    if (btnRemove) {
        btnRemove.addEventListener('click', () => {

            const doRemove = () => {
                preview.src = DEFAULT_AVATAR;
                if (avatar) avatar.src = DEFAULT_AVATAR;
                if (photoInput) photoInput.value = '';
                if (removeEl) removeEl.value = 1;

                btnRemove.classList.add('d-none');
            };

            if (!window.Swal) {
                if (confirm('Foto profil akan dihapus. Lanjutkan?')) {
                    doRemove();
                }
                return;
            }

            Swal.fire({
                title: 'Yakin?',
                text: 'Foto profil akan dihapus',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(res => {
                if (res.isConfirmed) {
                    doRemove();
                }
            });
        });
    }

    /* ================= TENTANG SAYA ================= */
    const textarea = document.getElementById('tentangSayaInput');
    const counter  = document.getElementById('charCount');
    const output   = document.getElementById('tentangSayaOutput');

    if (textarea && counter) {
        const updateCounter = () => counter.innerText = textarea.value.length;
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
            body: JSON.stringify({ tentang_saya: textarea.value })
        })
        .then(r => r.json())
        .then(data => {
            output.innerText = data.tentang_saya || '';
            showAlert({ text: 'Tentang saya berhasil disimpan' });
            window.bootstrap?.Modal
                .getInstance(document.getElementById('modalTentangSaya'))
                ?.hide();
        });
    };

});
