<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekrutmen HRD</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            margin-bottom: 6px;
        }
        p {
            margin: 0 0 12px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background: #eee;
        }
    </style>
</head>
<body>

<h2>Laporan Rekrutmen (HRD)</h2>

<p>
    Periode:
    {{ request('from') ?? '-' }}
    s/d
    {{ request('to') ?? '-' }}
</p>

<table>
    <thead>
        <tr>
            <th>Total</th>
            <th>Screening</th>
            <th>Seleksi (SAW)</th>
            <th>Interview</th>
            <th>Offer</th>
            <th>Diterima</th>
            <th>Ditolak</th>
            <th>Lolos (%)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $totalPelamar }}</td>
            <td>{{ $screening }}</td>
            <td>{{ $seleksiSaw }}</td>
            <td>{{ $interview }}</td>
            <td>{{ $offer }}</td>
            <td>{{ $diterima }}</td>
            <td>{{ $ditolak }}</td>
            <td>{{ $persenLolos }}%</td>
        </tr>
    </tbody>
</table>


</body>
</html>
