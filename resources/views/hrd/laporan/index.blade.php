@extends('layouts.hrd')

@section('title', 'Laporan Screening Kandidat')

{{-- ================= BREADCRUMB ================= --}}
@section('breadcrumb')
<nav class="breadcrumb-wrapper">
    <a href="{{ route('lowongan.index') }}">Lowongan</a>
    <span>/</span>
    <a href="{{ route('hrd.kandidat.index', $lowongan) }}">Kelola Kandidat</a>
    <span>/</span>
    <span class="active">Lihat Laporan</span>
</nav>
@endsection

@section('content')

<h4 class="fw-bold mb-3">
    Perhitungan Shortlisting Kandidat (Metode SAW)
</h4>

{{-- ================= ACTION ================= --}}
<div class="d-flex gap-2 mb-4">
    <button class="btn btn-danger"
            onclick="openPdfPreview()">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </button>

    <a href="/dummy/laporan-saw.xlsx"
       download
       class="btn btn-success">
        <i class="bi bi-file-earmark-excel"></i> Export Excel
    </a>
</div>

{{-- ================= INFORMASI LOWONGAN ================= --}}
<div class="card shadow-sm mb-4">
    <div class="card-body small">
        <strong>Informasi Lowongan</strong>
        <div class="mt-2">
            <div>[ Nama Lowongan ] : Staff Administrasi</div>
            <div>[ Tanggal Screening ] : 14 Desember 2025</div>
            <div>[ Jumlah Kandidat ] : 10 Orang</div>
            <div>[ Metode ] : Simple Additive Weighting (SAW)</div>
        </div>
    </div>
</div>

{{-- ================= KRITERIA ================= --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <strong>Kriteria & Bobot</strong>
        <p class="text-muted small">
            Bobot ditentukan oleh HRD sesuai kebutuhan lowongan
        </p>

        <table class="table table-bordered table-sm text-center">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Kriteria</th>
                    <th>Jenis</th>
                    <th>Bobot</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>C1</td>
                    <td>Pendidikan Terakhir</td>
                    <td>Benefit</td>
                    <td>0.30</td>
                </tr>
                <tr>
                    <td>C2</td>
                    <td>Pengalaman Kerja</td>
                    <td>Benefit</td>
                    <td>0.40</td>
                </tr>
                <tr>
                    <td>C3</td>
                    <td>Keahlian</td>
                    <td>Benefit</td>
                    <td>0.30</td>
                </tr>
                <tr class="fw-bold">
                    <td colspan="3">Total</td>
                    <td>1.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ================= DATA AWAL ================= --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <strong>Data Awal Kandidat</strong>

        <table class="table table-bordered table-sm text-center mt-3">
            <thead class="table-light">
                <tr>
                    <th>Kandidat</th>
                    <th>C1</th>
                    <th>C2</th>
                    <th>C3</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Joodiva</td>
                    <td>4</td>
                    <td>5</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>Naruto</td>
                    <td>2</td>
                    <td>2</td>
                    <td>6</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ================= NORMALISASI ================= --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <strong>Matriks Normalisasi</strong>

        <table class="table table-bordered table-sm text-center mt-3">
            <thead class="table-light">
                <tr>
                    <th>Kandidat</th>
                    <th>R1</th>
                    <th>R2</th>
                    <th>R3</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Joodiva</td>
                    <td>1.00</td>
                    <td>1.00</td>
                    <td>0.50</td>
                </tr>
                <tr>
                    <td>Naruto</td>
                    <td>0.50</td>
                    <td>0.40</td>
                    <td>1.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ================= SKOR AKHIR ================= --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <strong>Skor Akhir</strong>

        <table class="table table-bordered table-sm text-center mt-3">
            <thead class="table-light">
                <tr>
                    <th>Kandidat</th>
                    <th>Skor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Naruto</td>
                    <td>0.85</td>
                </tr>
                <tr>
                    <td>Joodiva</td>
                    <td>0.82</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ================= RANKING ================= --}}
<div class="card shadow-sm mb-5">
    <div class="card-body">
        <strong>Ranking Kandidat</strong>

        <table class="table table-bordered table-sm text-center mt-3">
            <thead class="table-light">
                <tr>
                    <th>Ranking</th>
                    <th>Kandidat</th>
                    <th>Skor</th>
                </tr>
            </thead>
            <tbody>
                <tr class="fw-bold">
                    <td>1</td>
                    <td>Naruto</td>
                    <td>0.85</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Joodiva</td>
                    <td>0.82</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ================= MODAL PREVIEW PDF ================= --}}
<div class="modal fade" id="modalPdfPreview" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    Preview Laporan Screening (PDF)
                </h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-0">
                <iframe id="pdfFrame"
                        src=""
                        width="100%"
                        height="600px"
                        style="border:none;">
                </iframe>
            </div>

            <div class="modal-footer">
                <a id="downloadPdfBtn"
                   href="#"
                   download
                   class="btn btn-danger">
                    <i class="bi bi-download"></i> Download PDF
                </a>
                <button class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    function openPdfPreview() {

        // 🔹 FILE PDF DUMMY (NANTI GANTI HASIL BACKEND)
        const pdfUrl = "/dummy/laporan-saw.pdf";

        // set iframe src
        document.getElementById('pdfFrame').src = pdfUrl;

        // set download link
        document.getElementById('downloadPdfBtn').href = pdfUrl;

        // tampilkan modal
        const modal = new bootstrap.Modal(
            document.getElementById('modalPdfPreview')
        );
        modal.show();
    }
</script>
@endpush
