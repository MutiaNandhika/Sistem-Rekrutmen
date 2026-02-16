<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Rekrutmen HRD</title>
<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
}
h2 { margin-bottom: 6px; }
p { margin: 2px 0; }
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
th, td {
    border: 1px solid #000;
    padding: 4px;
    text-align: center;
}
th { background: #eee; }
.info-box {
    margin-bottom: 10px;
}
</style>
</head>
<body>

<h2>Laporan Rekrutmen (HRD)</h2>

<div class="info-box">
    <p><strong>HRD :</strong> {{ $namaHrd }}</p>
    <p><strong>Lowongan :</strong> {{ $namaLowongan }}</p>
    <p><strong>Periode :</strong>
        {{ $from ?? '-' }} s/d {{ $to ?? '-' }}
    </p>
</div>

<table>
<thead>
<tr>
    <th>Total</th>
    <th>Diproses</th>
    <th>Screening</th>
    <th>Seleksi</th>
    <th>Tidak Lolos SAW</th>
    <th>Interview</th>
    <th>Offer</th>
    <th>Offer Ditolak</th>
    <th>Ditolak Admin</th>
    <th>Diterima</th>
    <th>Ditolak</th>
    <th>Lolos (%)</th>
</tr>
</thead>

<tbody>
<tr>
    <td>{{ $totalPelamar }}</td>
    <td>{{ $diproses }}</td>
    <td>{{ $screening }}</td>
    <td>{{ $seleksiSaw }}</td>
    <td>{{ $tidakLolosSaw }}</td>
    <td>{{ $interview }}</td>
    <td>{{ $offer }}</td>
    <td>{{ $offerDitolak }}</td>
    <td>{{ $ditolakAdministrasi }}</td>
    <td>{{ $diterima }}</td>
    <td>{{ $ditolak }}</td>
    <td>{{ $persenLolos }}%</td>
</tr>
</tbody>
</table>

</body>
</html>
