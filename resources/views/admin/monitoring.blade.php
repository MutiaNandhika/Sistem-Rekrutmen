@extends('layouts.admin')

@section('title', 'Monitoring Rekrutmen')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">Monitoring & Statistik Rekrutmen</h4>

    <select class="form-select w-auto">
        <option selected>2020</option>
        <option>2021</option>
        <option>2022</option>
    </select>
</div>

{{-- ================= STAT CARDS ================= --}}
<div class="row g-4 mb-4">

    <div class="col-md-3">
        <div class="dashboard-stat-card">
            <div class="stat-title">Lowongan Aktif</div>
            <div class="stat-value">12</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="dashboard-stat-card">
            <div class="stat-title">Total Pelamar</div>
            <div class="stat-value">1.290</div>
        </div>
    </div>

</div>

{{-- ================= CHART SECTION ================= --}}
<div class="row g-4">

    {{-- JUMLAH LOWONGAN --}}
    <div class="col-lg-4">
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                Jumlah Lowongan
            </div>
            <div class="dashboard-card-body">
                <canvas id="chartLowongan"></canvas>
            </div>
        </div>
    </div>

    {{-- FUNNEL --}}
    <div class="col-lg-4">
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <span>Funnel Rekrutmen</span>

                <select class="dashboard-select">
                    <option>Januari</option>
                    <option>Februari</option>
                </select>
            </div>

            <div class="dashboard-card-body">
                <canvas id="chartFunnel"></canvas>
            </div>
        </div>
    </div>

    {{-- STATUS OFFER --}}
    <div class="col-lg-4">
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <span>Status Offer</span>

                <select class="dashboard-select">
                    <option>Januari</option>
                    <option>Februari</option>
                </select>
            </div>

            <div class="dashboard-card-body">
                <canvas id="chartOffer"></canvas>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
/* =======================
   JUMLAH LOWONGAN
======================= */
new Chart(document.getElementById('chartLowongan'), {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [{
            label: 'Lowongan',
            data: [5,7,9,4,10,8,6,7,5,9,11,4],
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13,110,253,0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
});

/* =======================
   FUNNEL REKRUTMEN
======================= */
new Chart(document.getElementById('chartFunnel'), {
    type: 'bar',
    data: {
        labels: ['Diproses','Screening','Interview','Offer','Hired'],
        datasets: [{
            data: [120,80,35,10,5],
            backgroundColor: '#0d6efd'
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        }
    }
});

/* =======================
   STATUS OFFER
======================= */
new Chart(document.getElementById('chartOffer'), {
    type: 'bar',
    data: {
        labels: ['Offer Dikirim','Offer Diterima','Offer Ditolak','Tidak Merespon'],
        datasets: [{
            data: [10,6,3,1],
            backgroundColor: '#0d6efd'
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
@endpush
