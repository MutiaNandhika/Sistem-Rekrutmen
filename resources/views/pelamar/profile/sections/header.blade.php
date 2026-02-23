{{-- Profile Page --}}
<div class="container py-5 profile-page">

    <div class="profile-card mb-5">
        <div class="d-flex align-items-start gap-4">

            {{-- ================= AVATAR ================= --}}
            <div class="profile-avatar">
                <img
                    id="profileAvatar"
                    src="{{ $user->pelamarProfile?->photo
                        ? file_url($user->pelamarProfile->photo)
                        : asset('images/default-avatar.png') }}"
                    class="rounded-circle"
                    width="96"
                    height="96"
                    style="object-fit:cover"
                    alt="Avatar">
            </div>

            {{-- ================= USER INFO ================= --}}
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="fw-bold mb-3" data-profile-name>
                        {{ $user->name }}
                    </h5>
                    <a href="#"
                       class="text-primary fw-semibold text-decoration-none"
                       data-bs-toggle="modal"
                       data-bs-target="#modalDataDiri">
                        <i class="bi bi-pencil-square"></i> Ubah data diri
                    </a>
                </div>

                {{-- ================= DETAIL ================= --}}
                <div class="row text-muted small">

                    <div class="col-md-6 mb-2">
                        <strong>WHATSAPP NUMBER</strong><br>
                        <span data-profile-phone>{{ $user->pelamarProfile->phone ?? '-' }}</span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>EMAIL</strong><br>
                        {{ $user->email }}
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>LOKASI</strong><br>
                        <span data-profile-location>{{ $user->pelamarProfile->location ?? '-' }}</span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>USIA</strong><br>
                        <span data-profile-age>{{ $user->pelamarProfile->age ?? '-' }}</span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>PENDIDIKAN TERAKHIR</strong><br>
                        <span data-profile-education>{{ $user->pelamarProfile->last_education ?? '-' }}</span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>JENIS KELAMIN</strong><br>
                        <span data-profile-gender>{{ $user->pelamarProfile->gender ?? '-' }}</span>
                    </div>

                </div>
            </div>
        </div>
    </div>