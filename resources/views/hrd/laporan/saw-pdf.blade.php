<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan SAW</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2, h4 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background: #f2f2f2;
        }
        .left {
            text-align: left;
        }
    </style>
</head>
<body>

<h2>LAPORAN SCREENING KANDIDAT</h2>
<h4>Metode Simple Additive Weighting (SAW)</h4>

<p>
    <strong>Lowongan:</strong> {{ $lowongan->nama_lowongan }} <br>
    <strong>Tanggal:</strong> {{ now()->translatedFormat('d F Y') }} <br>
    <strong>Jumlah Kandidat:</strong> {{ $apps->count() }}
</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kandidat</th>
            <th>C1<br>(Pendidikan)</th>
            <th>C2<br>(Pengalaman)</th>
            <th>C3<br>(Skill)</th>
            <th>Skor SAW</th>
            <th>Ranking</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($apps as $i => $a)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td class="left">{{ $a->user->name }}</td>
            <td>{{ $matrix[$a->id]['pendidikan'] }}</td>
            <td>{{ $matrix[$a->id]['pengalaman'] }}</td>
            <td>{{ $matrix[$a->id]['skill'] }}</td>
            <td>{{ number_format($a->saw_score, 3) }}</td>
            <td>{{ $a->saw_rank }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p style="margin-top:30px;">
    <strong>Kesimpulan:</strong><br>
    Kandidat dengan peringkat tertinggi direkomendasikan untuk
    melanjutkan ke tahap seleksi berikutnya.
</p>

</body>
</html>
