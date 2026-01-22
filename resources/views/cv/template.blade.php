<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV {{ $user->name }}</title>

    <style>
        {!! file_get_contents(public_path('css/cv/cv.css')) !!}
    </style>
</head>
<body>

@php
    use Carbon\Carbon;

    $bulan = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
    ];
@endphp

{{-- ================= HEADER ================= --}}
<h1>{{ $user->name }}</h1>

<div class="header-meta">
    {{ $user->email }}
    @if($user->pelamarProfile?->phone)
        • {{ $user->pelamarProfile->phone }}
    @endif
</div>

@if($user->pelamarProfile?->location)
<div class="header-meta">
    {{ $user->pelamarProfile->location }}
</div>
@endif

<hr>

{{-- ================= TENTANG SAYA ================= --}}
@if($user->pelamarProfile?->tentang_saya)
<h2>Tentang Saya</h2>
<p>{{ $user->pelamarProfile->tentang_saya }}</p>
<hr>
@endif

{{-- ================= PENGALAMAN KERJA ================= --}}
@if($user->pelamarExperiences->count())
<h2>Pengalaman Kerja</h2>

@foreach($user->pelamarExperiences as $exp)
<div class="section-item">
    <strong>{{ $exp->posisi }}</strong><br>

    <span class="sub-text">
        {{ $exp->perusahaan }} •
        {{ Carbon::parse($exp->tanggal_mulai)->format('M Y') }}
        –
        @if($exp->masih_bekerja)
            Sekarang
        @elseif($exp->tanggal_selesai)
            {{ Carbon::parse($exp->tanggal_selesai)->format('M Y') }}
        @endif
    </span>

    @if($exp->deskripsi)
        <div class="desc">
            {{ $exp->deskripsi }}
        </div>
    @endif
</div>
@endforeach

<hr>
@endif

{{-- ================= PENDIDIKAN ================= --}}
@if($user->pelamarEducations->count())
<h2>Pendidikan</h2>

@foreach($user->pelamarEducations as $edu)
<div class="section-item">
    <strong>{{ $edu->nama_sekolah }}</strong><br>

    <span class="sub-text">
        {{ $edu->tingkat }} • {{ $edu->bidang_studi }}<br>
        {{ $bulan[$edu->mulai_bulan] ?? '' }} {{ $edu->mulai_tahun }}
        –
        {{ $edu->selesai_bulan ? ($bulan[$edu->selesai_bulan].' '.$edu->selesai_tahun) : 'Sekarang' }}
    </span>

    @if($edu->informasi_tambahan)
        <div class="desc">{{ $edu->informasi_tambahan }}</div>
    @endif
</div>
@endforeach

<hr>
@endif

{{-- ================= SKILLS ================= --}}
@if($user->pelamarSkills->count())
<h2>Keahlian</h2>
<ul>
@foreach($user->pelamarSkills as $skill)
    <li>{{ $skill->nama_skill }}</li>
@endforeach
</ul>
<hr>
@endif

{{-- ================= SERTIFIKAT ================= --}}
@if($user->pelamarCertificates->count())
<h2>Sertifikat</h2>

@foreach($user->pelamarCertificates as $cert)
<div class="section-item">
    <strong>{{ $cert->nama_sertifikat }}</strong><br>

    <span class="sub-text">
        @if($cert->bulan_terbit)
            {{ $bulan[$cert->bulan_terbit] }}
        @endif
        {{ $cert->tahun_terbit }}

        @if($cert->tanpa_expired)
            • Tidak kedaluwarsa
        @elseif($cert->bulan_expired && $cert->tahun_expired)
            – {{ $bulan[$cert->bulan_expired] }} {{ $cert->tahun_expired }}
        @endif
    </span>

    @if($cert->informasi_tambahan)
        <div class="desc">{{ $cert->informasi_tambahan }}</div>
    @endif
</div>
@endforeach

<hr>
@endif

{{-- ================= PENGHARGAAN ================= --}}
@if($user->pelamarAchievements->count())
<h2>Penghargaan</h2>

@foreach($user->pelamarAchievements as $award)
<div class="section-item">
    <strong>{{ $award->judul }}</strong><br>
    <span class="sub-text">
        {{ $award->penyelenggara }} • {{ $award->tahun }}
    </span>

    @if($award->deskripsi)
        <div class="desc">{{ $award->deskripsi }}</div>
    @endif
</div>
@endforeach

<hr>
@endif

{{-- ================= ORGANISASI ================= --}}
@if($user->pelamarOrganizations->count())
<h2>Pengalaman Organisasi</h2>

@foreach($user->pelamarOrganizations as $org)
<div class="section-item">
    <strong>{{ $org->nama_organisasi }}</strong><br>

    <span class="sub-text">
        {{ $org->posisi }} •
        {{ $bulan[$org->mulai_bulan] ?? '' }} {{ $org->mulai_tahun }}
        –
        @if($org->masih_aktif)
            Sekarang
        @else
            {{ $bulan[$org->selesai_bulan] ?? '' }} {{ $org->selesai_tahun }}
        @endif
    </span>

    @if($org->informasi_tambahan)
        <div class="desc">{{ $org->informasi_tambahan }}</div>
    @endif
</div>
@endforeach
@endif

</body>
</html>
