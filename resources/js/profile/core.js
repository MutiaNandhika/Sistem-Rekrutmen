function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();

    reader.onload = function(e) {
        document.getElementById('avatarPreview').src = e.target.result;
        document.getElementById('avatarPreview').classList.remove('d-none');
        document.getElementById('avatarIcon').classList.add('d-none');
    };

    reader.readAsDataURL(file);
}

function updateCounter() {
    const textarea = document.getElementById('tentangSayaInput');
    document.getElementById('charCount').innerText = textarea.value.length;
}

function saveTentangSaya() {
    const value = document.getElementById('tentangSayaInput').value;
    document.getElementById('tentangSayaOutput').innerText =
        value || 'Belum ada deskripsi.';
}