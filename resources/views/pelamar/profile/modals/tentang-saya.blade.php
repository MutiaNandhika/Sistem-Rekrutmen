{{-- ========================= MODAL TENTANG SAYA ========================= --}}
<div class="modal fade" id="modalTentangSaya" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow">

            {{-- HEADER --}}
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Tentang Saya</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body px-4">

                <p class="text-muted small mb-2">
                    Beritahu tentang dirimu sehingga perusahaan lebih mudah memahami potensimu.
                </p>

                <textarea
                id="tentangSayaInput"
                class="form-control"
                rows="5"
                maxlength="2600"
                placeholder="Ceritakan tentang dirimu..."
                oninput="updateCounter()">{{ $user->pelamarProfile->tentang_saya }}</textarea>

                <div class="d-flex justify-content-end mt-1">
                    <small class="text-muted">
                        <span id="charCount">0</span> / 2600
                    </small>
                </div>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0">

                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Batal
                </button>

                <button type="button"
                        class="btn btn-primary px-4"
                        onclick="saveTentangSaya()"
                        data-bs-dismiss="modal">
                    Simpan
                </button>

            </div>

        </div>

    </div>

</div>

<script>
function updateCounter() {
    const textarea = document.getElementById('tentangSayaInput');
    const counter = document.getElementById('charCount');
    counter.innerText = textarea.value.length;
}

document.addEventListener('DOMContentLoaded', function () {
    updateCounter();
});

function saveTentangSaya() {
    const text = document.getElementById('tentangSayaInput').value;

    fetch("{{ route('pelamar.profile.tentang-saya') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            tentang_saya: text
        })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('tentangSayaOutput').innerText =
            data.tentang_saya || 'Jelaskan secara singkat kelebihanmu sehingga perusahaan yakin untuk merekrutmu.';
    })
    .catch(() => {
        alert('Gagal menyimpan Tentang Saya');
    });
}
</script>
