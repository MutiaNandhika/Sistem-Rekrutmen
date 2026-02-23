@extends('layouts.hrd')

@section('title', 'Detail Kandidat')

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
    use Illuminate\Support\Facades\Storage;
    use Carbon\Carbon;

    function bulan($angka) {
        return Carbon::create()->month((int)$angka)->translatedFormat('F');
    }

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

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Detail Kandidat</h4>
    <a href="{{ route('hrd.kandidat.index', $lowongan) }}" class="btn btn-light border">
        Kembali ke Kandidat
    </a>
</div>

<div class="row g-4">

{{-- Left Profile--}}

<div class="col-lg-7">
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex gap-4">
            @if($application->snap_photo)
                <img
                    src="{{ Storage::disk('s3')->temporaryUrl($application->snap_photo, now()->addMinutes(60)) }}"
                    alt="Foto Kandidat"
                    class="rounded-circle border"
                    width="72"
                    height="72"
                    style="object-fit:cover; cursor:pointer"
                    data-bs-toggle="modal"
                    data-bs-target="#modalAvatarPreview">
            @else
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border"
                    style="width:72px;height:72px">
                    <i class="bi bi-person fs-3 text-muted"></i>
                </div>
            @endif

            <div class="flex-grow-1">

                <h5 class="fw-bold mb-2 d-flex align-items-center gap-2">
                    {{ $application->snap_name }}
                    <span class="badge {{ $badgeClass }}">{{ $label }}</span>
                </h5>

                <div class="row small text-muted">
                    <div class="col-6 mb-2"><strong>WhatsApp</strong><br>{{ $application->snap_phone ?? '-' }}</div>
                    <div class="col-6 mb-2"><strong>Email</strong><br>{{ $application->snap_email }}</div>
                    <div class="col-6 mb-2"><strong>Lokasi</strong><br>{{ $application->snap_location ?? '-' }}</div>
                    <div class="col-6 mb-2"><strong>Usia</strong><br>{{ $application->snap_age ?? '-' }} tahun</div>
                    <div class="col-6 mb-2"><strong>Pendidikan Terakhir</strong><br>{{ $application->snap_last_education ?? '-' }}</div>
                    <div class="col-6 mb-2"><strong>Jenis Kelamin</strong><br>{{ $application->snap_gender ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Tentang Saya --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Tentang Saya</h6>
        <hr class="my-2">
        <p class="text-muted">{{ $application->snap_about ?? '-' }}</p>
    </div>

    {{-- Pengalaman Kerja --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Pengalaman Kerja</h6>
        <hr class="my-2">

        @forelse ($application->snap_experiences ?? [] as $exp)
            <div class="mb-3">
                <strong>{{ $exp['posisi'] ?? '-' }}</strong> – {{ $exp['perusahaan'] ?? '-' }}<br>

                <span class="text-muted small">
                    {{ $exp['tanggal_mulai'] ?? '-' }} –
                    {{ !empty($exp['masih_bekerja'])
                        ? 'Sekarang'
                        : ($exp['tanggal_selesai'] ?? '-') }}
                </span>

                @if(!empty($exp['deskripsi']))
                    <p class="text-muted mt-1">{{ $exp['deskripsi'] }}</p>
                @endif

                @if(!empty($exp['file_bukti']))
                    <div class="mt-2">
                        <a href="{{ Storage::disk('s3')->temporaryUrl($exp['file_bukti'], now()->addMinutes(60)) }}"
                        target="_blank"
                        class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-paperclip"></i> Lihat File
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-muted">Tidak ada pengalaman kerja.</p>
        @endforelse
    </div>

    {{-- Pendidikan --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Pendidikan</h6>
        <hr class="my-2">

        @forelse ($application->snap_educations ?? [] as $edu)
            <div class="mb-3">
                <strong>{{ $edu['nama_sekolah'] ?? '-' }}</strong><br>

                <span class="text-muted">
                    {{ $edu['tingkat'] ?? '-' }} – {{ $edu['bidang_studi'] ?? '-' }}
                </span><br>

                <span class="text-muted small">
                    {{ $edu['periode'] ?? '-' }}
                </span>

                @if(!empty($edu['informasi_tambahan']))
                    <p class="text-muted mt-1">{{ $edu['informasi_tambahan'] }}</p>
                @endif

                @if(!empty($edu['file_bukti']))
                    <div class="mt-2">
                        <a href="{{ Storage::disk('s3')->temporaryUrl($edu['file_bukti'], now()->addMinutes(60)) }}"
                        target="_blank"
                        class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-file-earmark-text"></i> Lihat File
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-muted">Data pendidikan belum tersedia.</p>
        @endforelse
    </div>

    {{-- Skills --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Skills</h6>
        <hr class="my-2">

        @if(!empty($application->snap_skills) && count($application->snap_skills))
            <div class="d-flex flex-wrap gap-2">
                @foreach ($application->snap_skills as $skill)
                    <span class="badge bg-light text-dark border">
                        {{ $skill }}
                    </span>
                @endforeach
            </div>
        @else
            <p class="text-muted">Tidak ada skill.</p>
        @endif
    </div>

    {{-- Resume --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Resume</h6>
        <hr class="my-2">

    @if(!empty($application->snap_resume['file_path']))
        <a href="{{ Storage::disk('s3')->temporaryUrl($application->snap_resume['file_path'], now()->addMinutes(60)) }}"
        target="_blank"
        class="btn btn-outline-primary btn-sm">
            <i class="bi bi-file-earmark-text"></i>
            Lihat Resume
        </a>

        <div class="small text-muted mt-1">
            {{ $application->snap_resume['file_name'] ?? '' }}
        </div>
    @else
        <p class="text-muted">Resume belum diunggah.</p>
    @endif

    </div>

    {{-- Penghargaan --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Penghargaan</h6>
        <hr class="my-2">

        @forelse ($application->snap_achievements ?? [] as $ach)
            <div class="mb-3">
                <strong>{{ $ach['judul'] ?? '' }}</strong> – {{ $ach['tahun'] ?? '' }}

                @if(!empty($ach['deskripsi']))
                    <p class="text-muted small mt-1">
                        {{ $ach['deskripsi'] }}
                    </p>
                @endif

                @if(!empty($ach['file_bukti']))
                    <div class="mt-2">
                        <a href="{{ Storage::disk('s3')->temporaryUrl($ach['file_bukti'], now()->addMinutes(60)) }}"
                        target="_blank"
                        class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-award"></i> Lihat File
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-muted">Tidak ada penghargaan.</p>
        @endforelse
    </div>

    {{-- Sertifikat --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Sertifikat</h6>
        <hr class="my-2">

        @forelse ($application->snap_certificates ?? [] as $cert)
            <div class="mb-3">
                <strong>{{ $cert['nama_sertifikat'] ?? '' }}</strong><br>

                <span class="text-muted small">
                    Terbit: {{ $cert['terbit'] ?? '-' }} ·
                    Berlaku: {{ $cert['expired'] ?? 'Tidak ada batas waktu' }}
                </span>

                @if(!empty($cert['informasi_tambahan']))
                    <p class="text-muted mt-1">
                        {{ $cert['informasi_tambahan'] }}
                    </p>
                @endif

                @if(!empty($cert['file_bukti']))
                    <div class="mt-2">
                        <a href="{{ Storage::disk('s3')->temporaryUrl($cert['file_bukti'], now()->addMinutes(60)) }}"
                        target="_blank"
                        class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-patch-check"></i> Lihat File
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-muted">Tidak ada sertifikat.</p>
        @endforelse
    </div>

    {{-- Organisasi --}}
    <div class="mb-4">
        <h6 class="fw-bold text-uppercase small">Organisasi & Relawan</h6>
        <hr class="my-2">

        @forelse ($application->snap_organizations ?? [] as $org)
            <div class="mb-3">
                <strong>{{ $org['nama_organisasi'] ?? '' }}</strong>
                – {{ $org['posisi'] ?? '-' }}<br>

                <span class="text-muted small">
                    {{ $org['periode'] ?? '-' }}
                </span>

                @if(!empty($org['informasi_tambahan']))
                    <p class="text-muted mt-1">
                        {{ $org['informasi_tambahan'] }}
                    </p>
                @endif

                @if(!empty($org['file_bukti']))
                    <div class="mt-2">
                        <a href="{{ Storage::disk('s3')->temporaryUrl($org['file_bukti'], now()->addMinutes(60)) }}"
                        target="_blank"
                        class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-paperclip"></i> Lihat File
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-muted">Tidak ada pengalaman organisasi.</p>
        @endforelse
    </div>

</div>

{{-- Right Tracking Lamaran --}}
<div class="col-lg-5">

    @if(!$isOwner)
        <div class="alert alert-info small">
            Anda sedang melihat kandidat ini sebagai <strong>viewer</strong>.
            Aksi seleksi hanya dapat dilakukan oleh HRD pembuat lowongan.
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <h6 class="fw-bold mb-4">Tracking Lamaran</h6>

            {{-- 1. Diproses --}}
            <div class="mb-4">
                <strong>1. DIPROSES</strong>

                @if($isOwner && $application->status === 'diproses')
                    <form method="POST"
                          action="{{ route('hrd.kandidat.status', [$lowongan->id, $application->id]) }}"
                          class="form-tracking-confirm"
                          data-title="Proses ke Screening?"
                          data-text="Kandidat akan masuk ke tahap screening administrasi.">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="screening">
                        <button class="btn btn-primary btn-sm mt-2">
                            Proses ke Screening
                        </button>
                    </form>
                @endif
            </div>

            {{-- 2. Screening --}}
            <div class="mb-4">
                <strong>2. SCREENING (Administrasi)</strong>

                @if($application->status === 'screening')
                    <p class="text-muted small mt-2">
                        Berkas administrasi kandidat sedang diperiksa.
                    </p>
                @elseif($application->status === 'ditolak_administrasi')
                    <p class="text-danger small mt-2 fw-semibold">
                        Kandidat <strong>DITOLAK</strong> pada tahap administrasi.
                    </p>
                @endif

                @if($isOwner && $application->status === 'screening')
                    <div class="d-flex gap-2 mt-2">

                        <form method="POST"
                              action="{{ route('hrd.kandidat.tolak_administrasi', [$lowongan->id, $application->id]) }}"
                              class="form-tracking-confirm"
                              data-title="Tolak Administrasi?"
                              data-text="Kandidat akan ditolak pada tahap administrasi.">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-danger btn-sm">
                                Ditolak Administrasi
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('hrd.kandidat.lolos_administrasi', [$lowongan->id, $application->id]) }}"
                              class="form-tracking-confirm"
                              data-title="Lolos Administrasi?"
                              data-text="Kandidat akan masuk ke tahap seleksi (SAW).">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-success btn-sm">
                                Lolos Administrasi
                            </button>
                        </form>

                    </div>
                @endif
            </div>

            {{-- 3. Seleksi --}}
            <div class="mb-4">
                <strong>3. SELEKSI</strong>

                @if($application->status === 'seleksi')
                    <p class="text-muted small mt-2">
                        Kandidat sedang dalam tahap seleksi lanjutan (SAW).
                    </p>
                @elseif($application->status === 'ditolak_administrasi')
                    <p class="text-danger small mt-2">
                        Tidak dilanjutkan ke tahap seleksi karena gagal administrasi.
                    </p>
                @endif
            </div>

            {{-- 4. Interview --}}
            <div class="mb-4">
                <strong>4. INTERVIEW</strong>

                @if($application->status === 'ditolak_administrasi')
                    <p class="text-danger small mt-2">
                        Proses berhenti. Kandidat tidak lolos tahap administrasi.
                    </p>

                @elseif($application->status === 'seleksi')
                    <p class="text-muted small mt-2">
                        Tahap interview akan tersedia setelah proses seleksi (SAW) selesai.
                    </p>

                @elseif($application->status === 'tidak_lolos_saw')
                    <p class="text-danger small mt-2">
                        Kandidat tidak lolos seleksi (SAW).
                    </p>

                @elseif($application->status === 'ditolak')
                    <p class="text-danger small mt-2">
                        Kandidat tidak lolos tahap interview.
                    </p>

                @elseif($application->status === 'interview')

                    @if($application->interview_at)
                        <div class="alert alert-warning small mt-2">
                            <div class="mb-1">
                                <strong>Metode:</strong> {{ ucfirst($application->interview_method) }}
                            </div>
                            <div class="mb-1">
                                <strong>Tanggal:</strong>
                                {{ $application->interview_at->translatedFormat('d F Y H:i') }}
                            </div>

                            @if($application->interview_link)
                                <div>
                                    <strong>Link:</strong>
                                    <a href="{{ $application->interview_link }}" target="_blank">
                                        {{ $application->interview_link }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-muted small mt-2">
                            Jadwal interview belum ditentukan.
                        </p>
                    @endif

                    {{-- Aksi Hrd --}}
                    @if($isOwner && $application->status === 'interview')
                        <div class="d-flex flex-column gap-2 mt-3">

                            <button
                                class="btn btn-outline-primary btn-sm align-self-start"
                                data-bs-toggle="modal"
                                data-bs-target="#modalInterview">
                                <i class="bi bi-calendar-event"></i>
                                Atur Jadwal Interview
                            </button>

                            <form method="POST"
                                action="{{ route('hrd.kandidat.status', [$lowongan->id, $application->id]) }}"
                                class="form-tracking-confirm"
                                data-title="Tidak Lolos Interview?"
                                data-text="Kandidat akan ditolak pada tahap interview.">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="ditolak">

                                <button class="btn btn-danger btn-sm"
                                        {{ is_null($application->interview_at) ? 'disabled' : '' }}>
                                    Tidak Lolos Interview
                                </button>
                            </form>

                            <form method="POST"
                                action="{{ route('hrd.kandidat.offer', [$lowongan->id, $application->id]) }}"
                                class="form-tracking-confirm"
                                data-title="Kirim Offer?"
                                data-text="Offer akan dikirim ke kandidat. Pastikan link sudah benar.">
                                @csrf

                                <input type="url"
                                    name="offer_file"
                                    class="form-control form-control-sm mb-2"
                                    placeholder="Link Offering (Google Drive / PDF)"
                                    required
                                    {{ is_null($application->interview_at) ? 'disabled' : '' }}>

                                <button class="btn btn-success btn-sm w-100"
                                        {{ is_null($application->interview_at) ? 'disabled' : '' }}>
                                    Kirim Offer
                                </button>
                            </form>

                            @if(is_null($application->interview_at))
                                <small class="text-muted">
                                    Jadwal interview harus dibuat terlebih dahulu.
                                </small>
                            @endif

                        </div>
                    @endif
    @endif
</div>
            {{-- 5. Offer --}}
            <div>
                <strong>5. OFFER</strong>

                @if($application->status === 'ditolak_administrasi')
                    <p class="text-danger small mt-2">
                        Proses tidak berlanjut ke tahap offer karena kandidat
                        <strong>gagal administrasi</strong>.
                    </p>

                @elseif($application->status === 'tidak_lolos_saw')
                    <p class="text-danger small mt-2">
                        Proses tidak berlanjut ke tahap offer karena kandidat
                        <strong>tidak lolos seleksi</strong>.
                    </p>

                @elseif($application->status === 'ditolak')
                    <p class="text-danger small mt-2">
                        Proses tidak berlanjut ke tahap offer karena kandidat
                        <strong>tidak lolos interview</strong>.
                    </p>

                @elseif($application->status === 'interview')
                    <p class="text-muted small mt-2">
                        Menunggu hasil interview sebelum keputusan offer.
                    </p>

                @elseif($application->status === 'offer')
                    <p class="text-muted small mt-2">
                        Offer telah dikirim ke pelamar dan menunggu respon.
                    </p>

                    @if($application->offer_file)
                        <a href="{{ $application->offer_file }}"
                        target="_blank"
                        class="btn btn-outline-primary btn-sm mb-2">
                            <i class="bi bi-file-earmark-text"></i> Lihat Offering
                        </a>
                    @endif

                    <p class="text-muted small">
                        Status respon pelamar:
                        <span class="badge bg-secondary">Menunggu</span>
                    </p>

                @elseif($application->status === 'offer_ditolak')
                    <div class="alert alert-warning small mt-2">
                        Kandidat <strong>menolak offer</strong> yang diberikan perusahaan.
                    </div>

                    @if($application->offer_file)
                        <a href="{{ $application->offer_file }}"
                        target="_blank"
                        class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-file-earmark-text"></i> Lihat Offering
                        </a>
                    @endif

                @elseif($application->status === 'diterima')
                    <p class="text-success small mt-2 fw-semibold">
                        Kandidat <strong>menerima offering</strong> dan resmi diterima bekerja.
                    </p>
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
            action="{{ route('hrd.kandidat.interview', [$lowongan->id, $application->id]) }}"
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
                    <button type="submit"
                            formaction="{{ route('hrd.kandidat.interview.delete', [$lowongan->id, $application->id]) }}"
                            formmethod="POST"
                            name="_method"
                            value="DELETE"
                            class="btn btn-outline-danger btn-sm">
                        Hapus Jadwal
                    </button>
                @endif

                <button class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>

</div>

{{-- Modal Avatar Preview --}}
@if(!empty($application->snap_photo))
<div class="modal fade" id="modalAvatarPreview" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body text-center p-0">

                <img
                    src="{{ Storage::disk('s3')->temporaryUrl($application->snap_photo, now()->addMinutes(60)) }}"
                    class="img-fluid rounded shadow"
                    alt="Preview Foto">

            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.form-tracking-confirm').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const title = form.dataset.title || 'Yakin melanjutkan?';
            const text  = form.dataset.text  || 'Aksi ini akan memproses status kandidat.';

            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

});
</script>
@endpush
