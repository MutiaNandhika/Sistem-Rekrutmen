<div class="modal fade" id="modalDataDiri" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4">

            <form id="formDataDiri" enctype="multipart/form-data">
                @csrf

                {{-- HEADER --}}
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Data Diri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                {{-- BODY --}}
                <div class="modal-body px-4">

                    <div class="text-center mb-4">

                        <img
                            id="photoPreview"
                            src="{{ $user->pelamarProfile?->photo
                                    ? asset('storage/'.$user->pelamarProfile->photo)
                                    : asset('images/default-avatar.png') }}"
                            class="rounded-circle mb-2"
                            width="96"
                            height="96"
                            style="object-fit:cover">

                        <div class="d-flex justify-content-center gap-2 mt-2">

                            <label for="photoInput"
                                class="btn btn-sm btn-outline-primary">
                                Ubah Foto
                            </label>

                            @if($user->pelamarProfile?->photo)
                                <button type="button"
                                        id="btnRemovePhoto"
                                        class="btn btn-sm btn-outline-danger">
                                    Hapus Foto
                                </button>
                            @endif
                        </div>

                        <input type="file"
                            name="photo"
                            id="photoInput"
                            accept="image/*"
                            hidden>

                        {{-- penanda hapus foto --}}
                        <input type="hidden"
                            name="remove_photo"
                            id="removePhoto"
                            value="0">
                    </div>

                    {{-- NAMA LENGKAP --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ $user->name }}"
                               required>
                    </div>

                    {{-- WHATSAPP --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nomor WhatsApp</label>
                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="{{ $user->pelamarProfile->phone ?? '' }}">
                        <small class="text-success">
                            <i class="bi bi-whatsapp"></i> Pastikan nomor WhatsApp aktif
                        </small>
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email"
                               class="form-control"
                               value="{{ $user->email }}"
                               disabled>
                        <small class="text-muted">Email telah diverifikasi</small>
                    </div>

                    {{-- LOKASI & USIA --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Lokasi</label>
                            <input type="text"
                                   name="location"
                                   class="form-control"
                                   value="{{ $user->pelamarProfile->location ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Usia</label>
                            <input type="number"
                                   name="age"
                                   class="form-control"
                                   value="{{ $user->pelamarProfile->age ?? '' }}">
                        </div>
                    </div>

                    {{-- PENDIDIKAN & GENDER --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pendidikan Terakhir</label>
                            <input type="text"
                                   name="last_education"
                                   class="form-control"
                                   value="{{ $user->pelamarProfile->last_education ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                            <select name="gender" class="form-select">
                                <option value="">Pilih</option>
                                <option value="Laki-laki"
                                    {{ $user->pelamarProfile->gender === 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="Perempuan"
                                    {{ $user->pelamarProfile->gender === 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
document.getElementById('formDataDiri').addEventListener('submit', function (e) {
    e.preventDefault();

    fetch("{{ route('pelamar.profile.data-diri') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        location.reload();
    })
    .catch(() => {
        alert("Gagal menyimpan data");
    });
});

document.addEventListener('DOMContentLoaded', function () {

    const photoInput   = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    const btnRemove    = document.getElementById('btnRemovePhoto');
    const removeInput  = document.getElementById('removePhoto');

    // ===== PREVIEW FOTO =====
    if (photoInput) {
        photoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = e => {
                photoPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);

            // batalin status hapus
            if (removeInput) removeInput.value = 0;
        });
    }

    // ===== HAPUS FOTO =====
    if (btnRemove) {
        btnRemove.addEventListener('click', function () {
            if (!confirm('Hapus foto profil?')) return;

            // reset preview ke default
            photoPreview.src = "{{ asset('images/default-avatar.png') }}";

            // kosongkan file input
            if (photoInput) photoInput.value = '';

            // tandai hapus foto
            if (removeInput) removeInput.value = 1;
        });
    }

});

</script>

