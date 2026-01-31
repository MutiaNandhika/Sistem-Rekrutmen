document.addEventListener('DOMContentLoaded', () => {

    /* ================= CSRF ================= */
    function csrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    /* ================= SWEETALERT HELPER ================= */
    window.showAlert = function ({
        icon = 'success',
        title = 'Berhasil',
        text = '',
        timer = 2000
    }) {
        if (typeof Swal === 'undefined') {
            alert(text || title);
            return;
        }

        Swal.fire({
            icon,
            title,
            text,
            timer,
            showConfirmButton: timer ? false : true
        });
    };

    /* ================= DATA DIRI ================= */
    const form = document.getElementById('formDataDiri');
    const modalEl = document.getElementById('modalDataDiri');

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
                if (!res.ok) throw new Error('Response not OK');
                return res.json();
            })
            .then(data => {

                showAlert({
                    icon: 'success',
                    title: 'Berhasil',
                    text: data.message
                });

                /* ================= CLOSE MODAL (AMAN) ================= */
                if (modalEl && window.bootstrap) {
                    const modal =
                        window.bootstrap.Modal.getInstance(modalEl)
                        || new window.bootstrap.Modal(modalEl);

                    modal.hide();
                }

                updateProfileView();
            })
            .catch(err => {
                console.error(err);
                showAlert({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal menyimpan data',
                    timer: null
                });
            });
        });
    }

    /* ================= UPDATE PROFILE CARD ================= */
    function updateProfileView() {
        if (!form) return;

        const name     = form.querySelector('[name="name"]').value;
        const phone    = form.querySelector('[name="phone"]').value;
        const location = form.querySelector('[name="location"]').value;
        const age      = form.querySelector('[name="age"]').value;
        const edu      = form.querySelector('[name="last_education"]').value;
        const gender   = form.querySelector('[name="gender"]').value;

        document.querySelectorAll('[data-profile-name]')
            .forEach(el => el.innerText = name);

        document.querySelectorAll('[data-profile-phone]')
            .forEach(el => el.innerText = phone || '-');

        document.querySelectorAll('[data-profile-location]')
            .forEach(el => el.innerText = location || '-');

        document.querySelectorAll('[data-profile-age]')
            .forEach(el => el.innerText = age || '-');

        document.querySelectorAll('[data-profile-education]')
            .forEach(el => el.innerText = edu || '-');

        document.querySelectorAll('[data-profile-gender]')
            .forEach(el => el.innerText = gender || '-');

        const preview = document.getElementById('photoPreview');
        const avatar  = document.getElementById('profileAvatar');

        if (preview && avatar) {
            avatar.src = preview.src;
        }
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

            if (typeof Swal === 'undefined') {
                if (!confirm('Hapus foto profil?')) return;
                photoPreview.src = '/images/default-avatar.png';
                photoInput.value = '';
                removeInput.value = 1;
                return;
            }

            Swal.fire({
                title: 'Yakin?',
                text: 'Foto profil akan dihapus',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (!result.isConfirmed) return;

                photoPreview.src = '/images/default-avatar.png';
                photoInput.value = '';
                removeInput.value = 1;
            });
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
            output.innerText = data.tentang_saya || '';

            showAlert({
                icon: 'success',
                title: 'Berhasil',
                text: 'Tentang saya berhasil disimpan'
            });

            if (window.bootstrap) {
                const modal = window.bootstrap.Modal.getInstance(
                    document.getElementById('modalTentangSaya')
                );
                modal && modal.hide();
            }
        })
        .catch(err => {
            console.error(err);
            showAlert({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal menyimpan Tentang Saya',
                timer: null
            });
        });
    };

});
