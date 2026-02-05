@extends('layouts.hrd')

@section('title', 'Dashboard HRD')

@section('content')

<div class="page-hrd-dashboard"><!-- 🔒 SCOPING WRAPPER -->

<div class="d-flex justify-content-between mb-4">
    <h4 class="fw-bold">Monitoring & Statistik Rekrutmen</h4>

    <div class="d-flex gap-2">
        <select id="tahun" class="form-select w-auto">
            @for ($y = now()->year; $y <= now()->year + 1; $y++)
                <option value="{{ $y }}">{{ $y }}</option>
            @endfor
        </select>

        <select id="bulan" class="form-select w-auto">
            @foreach ([
                1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',
                7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'
            ] as $k => $v)
                <option value="{{ $k }}" {{ $k == now()->month ? 'selected' : '' }}>
                    {{ $v }}
                </option>
            @endforeach
        </select>
    </div>
</div>

{{-- STAT CARD --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="dashboard-stat-card">
            <div class="stat-title">Lowongan Dibuat</div>
            <div class="stat-value" id="statLowongan">0</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="dashboard-stat-card">
            <div class="stat-title">Total Pelamar</div>
            <div class="stat-value" id="statPelamar">0</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="dashboard-card">
            <div class="dashboard-card-header">Jumlah Lowongan</div>
            <div class="dashboard-card-body">
                <canvas id="chartLowongan"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="dashboard-card">
            <div class="dashboard-card-header">Funnel Rekrutmen</div>
            <div class="dashboard-card-body">
                <canvas id="chartFunnel"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="dashboard-card">
            <div class="dashboard-card-header">Status Offer</div>
            <div class="dashboard-card-body">
                <canvas id="chartOffer"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
/* ===============================
   VARIABLE GLOBAL
================================ */
let chartLowongan, chartFunnel, chartOffer;
let refreshTimer;

const tahunSelect = document.getElementById('tahun');
const bulanSelect = document.getElementById('bulan');

const chartLowonganCtx = document.getElementById('chartLowongan');
const chartFunnelCtx   = document.getElementById('chartFunnel');
const chartOfferCtx    = document.getElementById('chartOffer');

/* ===============================
   LOAD DASHBOARD DATA
================================ */
function loadDashboard() {
    fetch(`/hrd/dashboard/data?tahun=${tahunSelect.value}&bulan=${bulanSelect.value}`)
        .then(response => response.json())
        .then(data => renderCharts(data))
        .catch(() => {
            alert('Gagal memuat data dashboard');
        });
}

/* ===============================
   RENDER CHART & STAT
================================ */
function renderCharts(data) {

    // STAT
    document.getElementById('statLowongan').textContent = data.stat.lowongan_aktif;
    document.getElementById('statPelamar').textContent  = data.stat.total_pelamar;

    // RESET CHART
    chartLowongan?.destroy();
    chartFunnel?.destroy();
    chartOffer?.destroy();

    // CHART LOWONGAN
    chartLowongan = new Chart(chartLowonganCtx, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                data: data.lowongan,
                borderColor: '#0d6efd',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            }
        }
    });

    // CHART FUNNEL
    chartFunnel = new Chart(chartFunnelCtx, {
        type: 'bar',
        data: {
            labels: ['Diproses','Screening','Interview','Offer','Hired'],
            datasets: [{
                data: Object.values(data.funnel),
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            }
        }
    });

    // CHART OFFER
    chartOffer = new Chart(chartOfferCtx, {
        type: 'bar',
        data: {
            labels: ['Dikirim','Diterima','Ditolak','Tidak Respon'],
            datasets: [{
                data: Object.values(data.offer),
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            }
        }
    });
}

/* ===============================
   AUTO REFRESH (POLLING)
================================ */
function startAutoRefresh() {
    clearInterval(refreshTimer);
    refreshTimer = setInterval(loadDashboard, 10000); // 10 detik
}

/* ===============================
   EVENT HANDLER
================================ */
tahunSelect.addEventListener('change', () => {
    loadDashboard();
    startAutoRefresh();
});

bulanSelect.addEventListener('change', () => {
    loadDashboard();
    startAutoRefresh();
});

/* ===============================
   INIT LOAD
================================ */
loadDashboard();
startAutoRefresh();
</script>
@endpush
