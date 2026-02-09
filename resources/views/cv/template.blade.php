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

    $profile = $user->pelamarProfile;

    $bulan = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
    ];
@endphp

{{-- ================= HEADER ================= --}}
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>

        {{-- FOTO --}}
        <td width="22%" valign="top">
            @if($profile && $profile->photo)
                <img
                    src="{{ public_path('storage/'.$profile->photo) }}"
                    class="cv-avatar"
                    alt="Foto {{ $user->name }}">
            @endif
        </td>

        {{-- IDENTITAS --}}
        <td width="78%" valign="top">
            <h1>{{ $user->name }}</h1>

            <div class="header-meta">
                {{ $user->email }}
                @if($profile?->phone)
                    • {{ $profile->phone }}
                @endif
            </div>

            @if($profile?->location)
                <div class="header-meta">
                    {{ $profile->location }}
                </div>
            @endif
        </td>
    </tr>
</table>

<hr>

{{-- ================= TENTANG SAYA ================= --}}
@if($profile?->tentang_saya)
<h2>Tentang Saya</h2>
<table width="100%">
    <tr>
        <td>{{ $profile->tentang_saya }}</td>
    </tr>
</table>
<hr>
@endif

{{-- ================= PENGALAMAN KERJA ================= --}}
@if($user->pelamarExperiences->count())
<h2>Pengalaman Kerja</h2>
<table width="100%" cellpadding="0" cellspacing="0">
@foreach($user->pelamarExperiences as $exp)
    <tr>
        <td>
            <strong>{{ $exp->posisi }}</strong><br>
            <span class="sub-text">
                {{ $exp->perusahaan }} •
                {{ Carbon::parse($exp->tanggal_mulai)->format('M Y') }}
                –
                {{ $exp->masih_bekerja
                    ? 'Sekarang'
                    : optional($exp->tanggal_selesai)->format('M Y') }}
            </span>

            @if($exp->deskripsi)
                <div class="desc">{{ $exp->deskripsi }}</div>
            @endif
        </td>
    </tr>
@endforeach
</table>
<hr>
@endif

{{-- ================= PENDIDIKAN ================= --}}
@if($user->pelamarEducations->count())
<h2>Pendidikan</h2>
<table width="100%" cellpadding="0" cellspacing="0">
@foreach($user->pelamarEducations as $edu)
    <tr>
        <td>
            <strong>{{ $edu->nama_sekolah }}</strong><br>
            <span class="sub-text">
                {{ $edu->tingkat }} • {{ $edu->bidang_studi }}<br>
                {{ $bulan[$edu->mulai_bulan] ?? '' }} {{ $edu->mulai_tahun }}
                –
                {{ $edu->selesai_bulan
                    ? ($bulan[$edu->selesai_bulan].' '.$edu->selesai_tahun)
                    : 'Sekarang' }}
            </span>

            @if($edu->informasi_tambahan)
                <div class="desc">{{ $edu->informasi_tambahan }}</div>
            @endif
        </td>
    </tr>
@endforeach
</table>
<hr>
@endif

{{-- ================= SKILLS ================= --}}
@if($user->pelamarSkills->count())
<h2>Keahlian</h2>
<table width="100%">
    <tr>
        <td>
            <ul>
                @foreach($user->pelamarSkills as $pelamarSkill)
                    @if($pelamarSkill->skill)
                        <li>{{ $pelamarSkill->skill->nama_skill }}</li>
                    @endif
                @endforeach
            </ul>
        </td>
    </tr>
</table>
<hr>
@endif

{{-- ================= SERTIFIKAT ================= --}}
@if($user->pelamarCertificates->count())
<h2>Sertifikat</h2>
<table width="100%" cellpadding="0" cellspacing="0">
@foreach($user->pelamarCertificates as $cert)
    <tr>
        <td>
            <strong>{{ $cert->nama_sertifikat }}</strong><br>

            <span class="sub-text">
                @if($cert->organisasi_penerbit)
                    {{ $cert->organisasi_penerbit }} •
                @endif

                {{ $bulan[$cert->bulan_terbit] ?? '' }} {{ $cert->tahun_terbit }}

                @if($cert->tanpa_expired)
                    • Tidak kedaluwarsa
                @elseif($cert->bulan_expired && $cert->tahun_expired)
                    – {{ $bulan[$cert->bulan_expired] }} {{ $cert->tahun_expired }}
                @endif
            </span>

            @if($cert->informasi_tambahan)
                <div class="desc">{{ $cert->informasi_tambahan }}</div>
            @endif
        </td>
    </tr>
@endforeach
</table>
<hr>
@endif

{{-- ================= PENGHARGAAN ================= --}}
@if($user->pelamarAchievements->count())
<h2>Penghargaan</h2>
<table width="100%">
@foreach($user->pelamarAchievements as $award)
    <tr>
        <td>
            <strong>{{ $award->judul }}</strong><br>
            <span class="sub-text">
                {{ $award->penyelenggara }} • {{ $award->tahun }}
            </span>

            @if($award->deskripsi)
                <div class="desc">{{ $award->deskripsi }}</div>
            @endif
        </td>
    </tr>
@endforeach
</table>
<hr>
@endif

{{-- ================= ORGANISASI ================= --}}
@if($user->pelamarOrganizations->count())
<h2>Pengalaman Organisasi</h2>
<table width="100%">
@foreach($user->pelamarOrganizations as $org)
    <tr>
        <td>
            <strong>{{ $org->nama_organisasi }}</strong><br>
            <span class="sub-text">
                {{ $org->posisi }} •
                {{ $bulan[$org->mulai_bulan] ?? '' }} {{ $org->mulai_tahun }}
                –
                {{ $org->masih_aktif
                    ? 'Sekarang'
                    : ($bulan[$org->selesai_bulan] ?? '').' '.$org->selesai_tahun }}
            </span>

            @if($org->informasi_tambahan)
                <div class="desc">{{ $org->informasi_tambahan }}</div>
            @endif
        </td>
    </tr>
@endforeach
</table>
@endif

</body>
</html>
