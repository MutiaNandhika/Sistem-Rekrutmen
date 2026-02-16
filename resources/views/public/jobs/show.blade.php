@extends('layouts.public')

@section('title', $lowongan->nama_lowongan)

@section('content')

<nav class="breadcrumb-wrapper">
    <a href="{{ route('public.home') }}">Beranda</a>
    <span>/</span>
    <a href="{{ route('jobs.index') }}">Lowongan</a>
    <span>/</span>
    <span class="active">{{ $lowongan->nama_lowongan }}</span>
</nav>

<section class="jobs-detail py-5">
    <div class="container">

        <div class="job-detail-header">
            <div class="job-detail-left">

                <div class="company-logo">
                    <i class="bi bi-building"></i>
                </div>

                <div class="job-detail-info">
                    <h3 class="job-title">{{ $lowongan->nama_lowongan }}</h3>

                    <ul class="job-meta-list">
                        <li><i class="bi bi-building"></i> {{ $lowongan->penempatan ?? 'Perusahaan Mitra' }}</li>
                        <li><i class="bi bi-cash"></i>
                            Rp {{ number_format($lowongan->gaji_min) }}
                            –
                            {{ number_format($lowongan->gaji_max) }}
                        </li>
                        <li><i class="bi bi-clock"></i>
                            {{ ucfirst(str_replace('_',' ',$lowongan->tipe_kerja)) }}
                            · {{ ucfirst($lowongan->sistem_kerja) }}
                        </li>

                        @if ($lowongan->tanggal_selesai)
                            <li>
                                <i class="bi bi-calendar-x"></i>
                                Pendaftaran ditutup pada
                                <strong>
                                    {{ \Carbon\Carbon::parse($lowongan->tanggal_selesai)->translatedFormat('d M Y') }}
                                </strong>
                            </li>
                        @else
                            <li>
                                <i class="bi bi-calendar-check"></i>
                                Pendaftaran tanpa batas waktu
                            </li>
                        @endif

                        <li><i class="bi bi-mortarboard"></i>
                            Minimal {{ $lowongan->pendidikan_minimal }}
                        </li>
                        <li><i class="bi bi-geo-alt"></i> {{ $lowongan->lokasi }}</li>
                    </ul>

                    <div class="mt-4">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-secondary">
                            Login untuk Melamar
                        </a>
                    @else

                        {{-- Bukan pelamar --}}
                        @if(auth()->user()->role !== 'pelamar')
                            <button class="btn btn-secondary" disabled>
                                Hanya Pelamar yang Bisa Melamar
                            </button>

                        {{-- Profil belum lengkap --}}
                        @elseif(!auth()->user()->isProfileComplete())
                            <button class="btn btn-warning" disabled
                                title="Lengkapi Data Diri, Tentang Saya, Pendidikan, Skills, dan Resume">
                                Lengkapi Profil
                            </button>

                        {{-- SUDAH DITERIMA (tidak boleh melamar lagi kemanapun) --}}
                        @elseif(
                            \App\Models\Application::where('user_id', auth()->id())
                                ->where('status', 'diterima')
                                ->exists()
                        )
                            <button class="btn btn-success" disabled>
                                Anda Sudah Diterima
                            </button>

                        {{-- SUDAH PERNAH MELAMAR LOWONGAN INI --}}
                        @elseif($application)

                            {{-- Sedang proses --}}
                            @if(in_array($application->status, [
                                'diproses',
                                'screening',
                                'seleksi',
                                'interview',
                                'offer'
                            ]))
                                <button class="btn btn-secondary" disabled>
                                    Lamaran Sedang Diproses
                                </button>

                            {{-- Ditolak → STRICT MODEL → tidak boleh apply lagi --}}
                            @elseif(in_array($application->status, [
                                'ditolak',
                                'ditolak_administrasi',
                                'tidak_lolos_saw',
                                'offer_ditolak'
                            ]))
                                <button class="btn btn-danger" disabled>
                                    Anda Sudah Pernah Melamar (Ditolak)
                                </button>

                            @else
                                <button class="btn btn-secondary" disabled>
                                    Tidak Dapat Melamar
                                </button>
                            @endif

                        {{-- BELUM PERNAH MELAMAR LOWONGAN INI --}}
                        @else
                            <form method="POST"
                                action="{{ route('pelamar.lamar.store', $lowongan->id) }}"
                                id="applyForm">
                                @csrf
                                <button type="button"
                                        class="btn btn-primary"
                                        id="applyBtn"
                                        onclick="confirmApply()">
                                    Lamar
                                </button>
                            </form>
                        @endif

                    @endguest
                    </div>

                </div>
            </div>
        </div>

        <hr class="my-5">

        <div class="row">

            <div class="col-md-6">
                <h5 class="fw-bold mb-3">Persyaratan</h5>
                <ul class="job-list">
                    <li>{{ ucfirst($lowongan->sistem_kerja) }}</li>
                    <li>{{ $lowongan->pendidikan_minimal }}</li>
                    @if(!$lowongan->tanpa_batas_usia)
                        <li>Usia {{ $lowongan->usia_min }} – {{ $lowongan->usia_max }} tahun</li>
                    @endif
                    <li>
                        <strong>Jenis Kelamin:</strong>
                        @if($lowongan->jenis_kelamin === 'semua')
                            Laki-laki & Perempuan
                        @else
                            {{ ucfirst($lowongan->jenis_kelamin) }}
                        @endif
                    </li>
                </ul>
            </div>

            <div class="col-md-6">
                <h5 class="fw-bold mb-3">Deskripsi Pekerjaan</h5>
                <p class="text-muted">
                    {!! nl2br(e($lowongan->deskripsi_pekerjaan)) !!}
                </p>
            </div>
        </div>

        {{-- SKILLS --}}
        <div class="mt-5">
            <h5 class="fw-bold mb-3">Skills yang Dibutuhkan</h5>

            @if ($lowongan->skills->count())
                <ul class="job-list">
                    @foreach ($lowongan->skills as $skill)
                        <li>{{ $skill->nama_skill }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">Tidak ada skill khusus.</p>
            @endif
        </div>


    </div>
</section>
@endsection
@push('scripts')
<script>
function confirmApply() {
    Swal.fire({
        title: 'Yakin ingin melamar?',
        text: 'Pastikan data profil kamu sudah benar sebelum melamar.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Lamar',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            const btn = document.getElementById('applyBtn');
            btn.disabled = true;
            btn.innerText = 'Mengirim lamaran...';

            document.getElementById('applyForm').submit();
        }
    });
}
</script>
@endpush

