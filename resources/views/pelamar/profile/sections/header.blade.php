{{-- ========================== PROFILE PAGE =============================== --}}

<div class="container py-5 profile-page">

    {{-- ========================= PROFILE CARD ============================ --}}

    <div class="profile-card mb-5">
        <div class="d-flex align-items-start gap-4">

            {{-- ================= AVATAR ================= --}}
            <div class="profile-avatar">
                @if($user->pelamarProfile?->photo)
                    <img
                        src="{{ asset('storage/'.$user->pelamarProfile->photo) }}"
                        class="rounded-circle"
                        width="96"
                        height="96"
                        style="object-fit:cover">
                @else
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                        style="width:96px;height:96px">
                        <i class="bi bi-person fs-2 text-muted"></i>
                    </div>
                @endif
            </div>


            {{-- ================= USER INFO ================= --}}
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="fw-bold mb-3">
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
                    {{ $user->pelamarProfile->phone ?? '-' }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>EMAIL</strong><br>
                    {{ $user->email }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>LOKASI</strong><br>
                    {{ $user->pelamarProfile->location ?? '-' }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>USIA</strong><br>
                    {{ $user->pelamarProfile->age ?? '-' }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>PENDIDIKAN TERAKHIR</strong><br>
                    {{ $user->pelamarProfile->last_education ?? '-' }}
                </div>

                <div class="col-md-6 mb-2">
                    <strong>JENIS KELAMIN</strong><br>
                    {{ $user->pelamarProfile->gender ?? '-' }}
                </div>

            </div>
            </div>
        </div>
    </div>