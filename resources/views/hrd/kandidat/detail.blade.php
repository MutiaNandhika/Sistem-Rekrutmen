@extends('layouts.hrd')

@section('title', 'Detail Kandidat')

{{-- ================= BREADCRUMB ================= --}}
@section('breadcrumb')
<nav class="breadcrumb-wrapper">
    <a href="{{ route('hrd.lowongan.index') }}">Lowongan</a>
    <span>/</span>
    <a href="{{ route('hrd.kandidat.index', $lowongan) }}">Kelola Kandidat</a>
    <span>/</span>
    <span class="active">Detail Kandidat</span>
</nav>
@endsection

@section('content')
@php
    use Carbon\Carbon;

    function bulan($angka) {
        return Carbon::create()->month((int)$angka)->translatedFormat('F');
    }

    $user    = $application->user;
    $profile = $user->pelamarProfile;

    $label = match($application->status) {
        'diproses' => 'Diproses',
        'screening' => 'Screening Administrasi',
        'seleksi' => 'Seleksi',
        'interview' => 'Interview',
        'offer' => 'Offer',
        'diterima' => 'Diterima',
        'ditolak' => 'Ditolak',
        'ditolak_administrasi' => 'Ditolak Administrasi',
        default => ucfirst($application->status),
    };

    $badgeClass = match($application->status) {
        'diterima' => 'bg-success',
        'ditolak', 'ditolak_administrasi' => 'bg-danger',
        'seleksi' => 'bg-info text-dark',
        'interview' => 'bg-primary',
        'offer' => 'bg-secondary',
        default => 'bg-warning text-dark',
    };
@endphp

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Detail Kandidat</h4>
    <a href="{{ route('hrd.kandidat.index', $lowongan) }}" class="btn btn-light border">
        ← Kembali ke Kandidat
    </a>
</div>

<div class="row g-4">

               {{-- ======================================================
| LEFT : PROFIL
====================================================== --}}
<div class="col-lg-7">

    {{-- PROFILE CARD --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex gap-4">

            <div class="avatar-lg text-muted">
                <i class="bi bi-person-circle fs-1"></i>
            </div>

            <div class="flex-grow-1">

                <h5 class="fw-bold mb-2 d-flex align-items-center gap-2">
                    {{ $user->name }}
                    <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                </h5>

                <div class="row small text-muted">
                    <div class="col-6 mb-2"><strong>WhatsApp</strong><br>{{ $profile->phone ?? '-' }}</div>
                    <div class="col-6 mb-2"><strong>Email</strong><br>{{ $user->email }}</div>
                    <div class="col-6 mb-2"><strong>Lokasi</strong><br>{{ $profile->location ?? '-' }}</div>
                    <div class="col-6 mb-2"><strong>Usia</strong><br>{{ $profile->age ?? '-' }} tahun</div>
                    <div class="col-6 mb-2"><strong>Pendidikan Terakhir</strong><br>{{ $profile->last_education ?? '-' }}</div>
                    <div class="col-6 mb-2"><strong>Jenis Kelamin</strong><br>{{ $profile->gender ?? '-' }}</div>
                </div>

            </div>
        </div>
    </div>
    
    {{-- TENTANG SAYA --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Tentang Saya</h6>
        <hr class="my-2">
        <p class="text-muted">{{ $profile->tentang_saya ?? '-' }}</p>
    </div>

    {{-- PENGALAMAN KERJA --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Pengalaman Kerja</h6>
        <hr class="my-2">

            @forelse ($user->pelamarExperiences as $exp)
        <div class="mb-3">
            <strong>{{ $exp->posisi }}</strong> – {{ $exp->perusahaan }}<br>
            <span class="text-muted small">
                {{ Carbon::parse($exp->tanggal_mulai)->translatedFormat('F Y') }}
                –
                {{ $exp->masih_bekerja
                    ? 'Sekarang'
                    : Carbon::parse($exp->tanggal_selesai)->translatedFormat('F Y') }}
            </span>

            @if($exp->deskripsi)
                <p class="text-muted mt-1">{{ $exp->deskripsi }}</p>
            @endif
        </div>
    @empty
        <p class="text-muted">Tidak ada pengalaman kerja.</p>
    @endforelse

    </div>

    {{-- PENDIDIKAN --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Pendidikan</h6>
        <hr class="my-2">

        @forelse ($user->pelamarEducations as $edu)
    <div class="mb-3">
        <strong>{{ $edu->nama_sekolah }}</strong><br>
        <span class="text-muted">
            {{ $edu->tingkat }} – {{ $edu->bidang_studi }}
        </span><br>

        <span class="text-muted small">
            {{ bulan($edu->mulai_bulan) }} {{ $edu->mulai_tahun }}
            –
            {{ bulan($edu->selesai_bulan) }} {{ $edu->selesai_tahun }}
        </span>

        @if($edu->informasi_tambahan)
            <p class="text-muted mt-1">{{ $edu->informasi_tambahan }}</p>
        @endif
    </div>
@empty
    <p class="text-muted">Data pendidikan belum tersedia.</p>
@endforelse

    </div>

    {{-- SKILLS --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Skills</h6>
        <hr class="my-2">

        @if ($user->pelamarSkills->count())
            <div class="d-flex flex-wrap gap-2">
                @foreach ($user->pelamarSkills as $skill)
                    <span class="badge bg-light text-dark border">{{ $skill->nama_skill }}</span>
                @endforeach
            </div>
        @else
            <p class="text-muted">Tidak ada skill.</p>
        @endif
    </div>

    {{-- RESUME --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Resume</h6>
        <hr class="my-2">

        @if ($user->pelamarResume)
            <a href="{{ asset('storage/'.$user->pelamarResume->file_path) }}"
               target="_blank"
               class="btn btn-outline-primary btn-sm">
                <i class="bi bi-file-earmark-text"></i> Lihat Resume
            </a>
        @else
            <p class="text-muted">Resume belum diunggah.</p>
        @endif
    </div>

    {{-- PENGHARGAAN --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Penghargaan</h6>
        <hr class="my-2">

        @forelse ($user->pelamarAchievements as $ach)
            <p class="mb-1">
                <strong>{{ $ach->judul }}</strong> – {{ $ach->tahun }}
            </p>
            <p class="text-muted small">{{ $ach->deskripsi }}</p>
        @empty
            <p class="text-muted">Tidak ada penghargaan.</p>
        @endforelse
    </div>

    {{-- SERTIFIKAT --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Sertifikat</h6>
        <hr class="my-2">

        @forelse ($user->pelamarCertificates as $cert)
    <div class="mb-3">
        <strong>{{ $cert->nama_sertifikat }}</strong><br>

        <span class="text-muted small">
            Terbit:
            {{ bulan($cert->bulan_terbit) }} {{ $cert->tahun_terbit }}
            ·
            Berlaku sampai:
            {{ $cert->tanpa_expired
                ? 'Tidak ada batas waktu'
                : bulan($cert->bulan_expired).' '.$cert->tahun_expired }}
        </span>

        @if($cert->informasi_tambahan)
            <p class="text-muted mt-1">{{ $cert->informasi_tambahan }}</p>
        @endif
    </div>
@empty
    <p class="text-muted">Tidak ada sertifikat.</p>
@endforelse

    </div>

    {{-- ORGANISASI & RELAWAN --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Pengalaman Organisasi & Relawan</h6>
        <hr class="my-2">

        @forelse ($user->pelamarOrganizations as $org)
    <div class="mb-3">
        <strong>{{ $org->nama_organisasi }}</strong>
        @if($org->posisi)
            – {{ $org->posisi }}
        @endif
        <br>

        <span class="text-muted small">
            {{ bulan($org->mulai_bulan) }} {{ $org->mulai_tahun }}
            –
            {{ $org->masih_aktif
                ? 'Sekarang'
                : bulan($org->selesai_bulan).' '.$org->selesai_tahun }}
        </span>

        @if($org->informasi_tambahan)
            <p class="text-muted mt-1">{{ $org->informasi_tambahan }}</p>
        @endif
    </div>
@empty
    <p class="text-muted">Tidak ada pengalaman organisasi atau relawan.</p>
@endforelse

    </div>

</div>


{{-- ======================================================
| RIGHT : TRACKING LAMARAN
====================================================== --}}

@if (!$isOwner)
    <div class="alert alert-info small">
        Anda sedang melihat kandidat ini sebagai <strong>viewer</strong>.
        Aksi seleksi hanya dapat dilakukan oleh HRD pembuat lowongan.
    </div>
@endif

<div class="col-lg-5">
    <div class="card shadow-sm">
        <div class="card-body">

            <h6 class="fw-bold mb-4">Tracking Lamaran</h6>

            {{-- ================= 1. DIPROSES ================= --}}
            <div class="mb-4">
                <strong>1. DIPROSES</strong>

                @if($isOwner && $application->status === 'diproses')
                    <form method="POST" action="{{ route('hrd.lamaran.update', $application) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="screening">
                        <button class="btn btn-primary btn-sm mt-2">
                            Proses ke Screening
                        </button>
                    </form>
                @endif
            </div>

            {{-- ================= 2. SCREENING ================= --}}
            <div class="mb-4">
                <strong>2. SCREENING (Administrasi)</strong>

                @if($application->status === 'screening')
                    <p class="text-muted small mt-2">
                        Berkas administrasi kandidat sedang diperiksa.
                    </p>
                @endif

                @if($isOwner && $application->status === 'screening')
                    <div class="d-flex gap-2 mt-2">

                        {{-- ❌ TOLAK ADMIN --}}
                        <form method="POST" action="{{ route('hrd.lamaran.update', $application) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="ditolak_administrasi">
                            <button class="btn btn-danger btn-sm">
                                Ditolak Administrasi
                            </button>
                        </form>

                        {{-- ✅ LOLOS ADMIN --}}
                        <form
                            action="{{ route('hrd.kandidat.lolos_administrasi', [$lowongan->id, $application->id]) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')
                            <button class="btn btn-success btn-sm">
                                Lolos Administrasi
                            </button>
                        </form>

                    </div>
                @endif
            </div>

            {{-- ================= 3. SELEKSI ================= --}}
            <div class="mb-4">
                <strong>3. SELEKSI</strong>

                @if($application->status === 'seleksi')
                    <p class="text-muted small mt-2">
                        Kandidat telah lolos administrasi dan
                        <strong>sedang dalam tahap seleksi lanjutan</strong>.
                    </p>
                @endif
            </div>

           {{-- ================= 4. INTERVIEW ================= --}}
<div class="mb-4">
    <strong>4. INTERVIEW</strong>

    {{-- 🔒 INTERVIEW TERKUNCI JIKA SAW BELUM SELESAI --}}
    @if(is_null($application->saw_score))
        <p class="text-muted small mt-2">
            Tahap interview akan tersedia setelah proses seleksi (SAW) selesai.
        </p>

    {{-- ❌ TIDAK LOLOS SAW --}}
    @elseif($application->status !== 'interview')
        <p class="text-muted small mt-2">
            Kandidat tidak termasuk dalam hasil seleksi interview.
        </p>

    {{-- ✅ LOLOS SAW & MASUK INTERVIEW --}}
    @else

        {{-- INFO INTERVIEW --}}
        @if($application->interview_at)
            <div class="alert alert-warning small mt-2">
                <strong>Metode:</strong> {{ ucfirst($application->interview_method) }}<br>
                <strong>Tanggal:</strong>
                {{ $application->interview_at->translatedFormat('d F Y H:i') }}<br>

                @if($application->interview_link)
                    <strong>Link:</strong>
                    <a href="{{ $application->interview_link }}" target="_blank">
                        {{ $application->interview_link }}
                    </a>
                @endif
            </div>
        @else
            <p class="text-muted small mt-2">
                Jadwal interview belum ditentukan.
            </p>
        @endif

        {{-- AKSI HRD --}}
        @if($isOwner)
            <div class="d-flex gap-2 mt-2">

                {{-- ❌ TIDAK LOLOS INTERVIEW --}}
                <form method="POST"
                      action="{{ route('hrd.lamaran.update', $application) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="ditolak">
                    <button class="btn btn-danger btn-sm">
                        Tidak Lolos
                    </button>
                </form>

                {{-- ✅ KIRIM OFFER --}}
                <form method="POST"
                      action="{{ route('hrd.lamaran.offer.upload', $application) }}">
                    @csrf
                    <input type="hidden" name="status" value="offer">

                    <input type="url"
                           name="offer_file"
                           class="form-control form-control-sm mb-2"
                           placeholder="Link Offering (Google Drive / PDF)"
                           required>

                    <button class="btn btn-success btn-sm">
                        Kirim Offer
                    </button>
                </form>

            </div>
        @endif

    @endif
</div>

{{-- ================= 5. OFFER ================= --}}
<div>
    <strong>5. OFFER</strong>

    @if($application->status === 'offer')
        <p class="text-muted small mt-2">
            Offering telah dikirim ke pelamar.
        </p>

        <a href="{{ $application->offer_file }}"
           target="_blank"
           class="btn btn-outline-primary btn-sm">
            Lihat Offering
        </a>
    @endif

    @if($application->offer_response)
        <span class="badge mt-2
            {{ $application->offer_response === 'diterima'
                ? 'bg-success'
                : 'bg-danger' }}">
            {{ ucfirst($application->offer_response) }}
        </span>
    @endif
</div>

<hr class="my-4">

<small class="text-muted">
    Terakhir diperbarui:
    {{ $application->updated_at->translatedFormat('d F Y') }}
</small>


<div class="modal fade" id="modalInterview" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST"
              action="{{ route('hrd.lamaran.interview', $application) }}"
              class="modal-content">

            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Atur Jadwal Interview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Metode Interview</label>
                    <select name="interview_method" class="form-select" required>
                        <option value="online" @selected($application->interview_method === 'online')>
                            Online
                        </option>
                        <option value="offline" @selected($application->interview_method === 'offline')>
                            Offline
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal & Jam</label>
                    <input type="datetime-local"
                           name="interview_at"
                           class="form-control"
                           value="{{ optional($application->interview_at)->format('Y-m-d\TH:i') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Link / Lokasi</label>
                    <input type="text"
                           name="interview_link"
                           class="form-control"
                           value="{{ $application->interview_link }}">
                </div>

            </div>

            <div class="modal-footer justify-content-between">
                @if($application->interview_at)
                    <form method="POST"
                          action="{{ route('hrd.lamaran.interview.delete', $application) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm">
                            Hapus Jadwal
                        </button>
                    </form>
                @endif

                <button class="btn btn  -primary">Simpan</button>
            </div>

        </form>
    </div>
</div>

</div>


@endsection
