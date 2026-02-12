<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV {{ $application->snap_name }}</title>

    <style>
        {!! file_get_contents(public_path('css/cv/cv.css')) !!}
    </style>
</head>
<body>

{{-- ================= HEADER ================= --}}
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>

        {{-- FOTO --}}
        <td width="22%" valign="top">
            @if(!empty($application->snap_photo))
                <img
                    src="{{ public_path('storage/'.$application->snap_photo) }}"
                    class="cv-avatar"
                    alt="Foto {{ $application->snap_name }}">
            @endif
        </td>

        {{-- IDENTITAS --}}
        <td width="78%" valign="top">
            <h1>{{ $application->snap_name }}</h1>

            <div class="header-meta">
                {{ $application->snap_email }}
                @if($application->snap_phone)
                    • {{ $application->snap_phone }}
                @endif
            </div>

            @if($application->snap_location)
                <div class="header-meta">
                    {{ $application->snap_location }}
                </div>
            @endif
        </td>
    </tr>
</table>

<hr>

{{-- ================= TENTANG SAYA ================= --}}
@if($application->snap_about)
<h2>Tentang Saya</h2>
<table width="100%">
    <tr>
        <td>{{ $application->snap_about }}</td>
    </tr>
</table>
<hr>
@endif

{{-- ================= PENGALAMAN KERJA ================= --}}
@if(!empty($application->snap_experiences))
<h2>Pengalaman Kerja</h2>
<table width="100%" cellpadding="0" cellspacing="0">
@foreach($application->snap_experiences as $exp)
    <tr>
        <td>
            <strong>{{ $exp['posisi'] ?? '' }}</strong><br>

            <span class="sub-text">
                {{ $exp['perusahaan'] ?? '' }} •

                {{ $exp['tanggal_mulai'] ?? '' }}
                –
                {{ !empty($exp['masih_bekerja'])
                    ? 'Sekarang'
                    : ($exp['tanggal_selesai'] ?? '') }}
            </span>

            @if(!empty($exp['deskripsi']))
                <div class="desc">{{ $exp['deskripsi'] }}</div>
            @endif
        </td>
    </tr>
@endforeach
</table>
<hr>
@endif

{{-- ================= PENDIDIKAN ================= --}}
@if(!empty($application->snap_educations))
<h2>Pendidikan</h2>
<table width="100%" cellpadding="0" cellspacing="0">
@foreach($application->snap_educations as $edu)
    <tr>
        <td>
            <strong>{{ $edu['nama_sekolah'] ?? '' }}</strong><br>

            <span class="sub-text">
                {{ $edu['tingkat'] ?? '' }}
                •
                {{ $edu['bidang_studi'] ?? '' }}<br>

                {{ $edu['periode'] ?? '' }}
            </span>

            @if(!empty($edu['informasi_tambahan']))
                <div class="desc">{{ $edu['informasi_tambahan'] }}</div>
            @endif
        </td>
    </tr>
@endforeach
</table>
<hr>
@endif

{{-- ================= SKILLS ================= --}}
@if(!empty($application->snap_skills))
<h2>Keahlian</h2>
<table width="100%">
    <tr>
        <td>
            <ul>
                @foreach($application->snap_skills as $skill)
                    <li>{{ $skill }}</li>
                @endforeach
            </ul>
        </td>
    </tr>
</table>
<hr>
@endif

{{-- ================= SERTIFIKAT ================= --}}
@if(!empty($application->snap_certificates))
<h2>Sertifikat</h2>
<table width="100%" cellpadding="0" cellspacing="0">
@foreach($application->snap_certificates as $cert)
    <tr>
        <td>
            <strong>{{ $cert['nama_sertifikat'] ?? '' }}</strong><br>

            <span class="sub-text">
                {{ $cert['terbit'] ?? '' }}

                @if(!empty($cert['expired']))
                    – {{ $cert['expired'] }}
                @endif
            </span>

            @if(!empty($cert['informasi_tambahan']))
                <div class="desc">{{ $cert['informasi_tambahan'] }}</div>
            @endif
        </td>
    </tr>
@endforeach
</table>
<hr>
@endif

{{-- ================= PENGHARGAAN ================= --}}
@if(!empty($application->snap_achievements))
<h2>Penghargaan</h2>
<table width="100%">
@foreach($application->snap_achievements as $award)
    <tr>
        <td>
            <strong>{{ $award['judul'] ?? '' }}</strong><br>

            <span class="sub-text">
                {{ $award['tahun'] ?? '' }}
            </span>

            @if(!empty($award['deskripsi']))
                <div class="desc">{{ $award['deskripsi'] }}</div>
            @endif
        </td>
    </tr>
@endforeach
</table>
<hr>
@endif

{{-- ================= ORGANISASI ================= --}}
@if(!empty($application->snap_organizations))
<h2>Pengalaman Organisasi</h2>
<table width="100%">
@foreach($application->snap_organizations as $org)
    <tr>
        <td>
            <strong>{{ $org['nama_organisasi'] ?? '' }}</strong><br>

            <span class="sub-text">
                {{ $org['posisi'] ?? '' }}
                •
                {{ $org['periode'] ?? '' }}
            </span>

            @if(!empty($org['informasi_tambahan']))
                <div class="desc">{{ $org['informasi_tambahan'] }}</div>
            @endif
        </td>
    </tr>
@endforeach
</table>
@endif

</body>
</html>
