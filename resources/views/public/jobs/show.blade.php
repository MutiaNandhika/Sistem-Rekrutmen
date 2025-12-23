@extends('layouts.public')

@section('title', 'Detail Lowongan')

@section('content')

{{-- BREADCRUMB --}}
<nav class="breadcrumb-wrapper">
    <a href="{{ route('public.home') }}">Beranda</a>
    <span>/</span>
    <a href="{{ route('jobs.index') }}">Lowongan</a>
    <span>/</span>
    <span class="active">Detail Lowongan</span>
</nav>


<section class="jobs-detail py-5">
    <div class="container">

        {{-- HEADER --}}
        <div class="job-detail-header">

            <div class="job-detail-left">
                <div class="company-logo">
                    <i class="bi bi-image"></i>
                </div>

                <div class="job-detail-info">
                    <h3 class="job-title">Office Girl</h3>

                    <ul class="job-meta-list">
                        <li><i class="bi bi-building"></i> PT JNE</li>
                        <li><i class="bi bi-cash"></i> Rp 2.000.000 – 3.000.000 / Bulan</li>
                        <li><i class="bi bi-clock"></i> Penuh Waktu · Kerja di Kantor</li>
                        <li><i class="bi bi-mortarboard"></i> Minimal SMA/SMK</li>
                        <li><i class="bi bi-geo-alt"></i> Jl. Merdeka no. 1945 Soedirman</li>
                    </ul>

                    <div class="mt-4">
                        <a href="#" class="btn-lamar">
                            Lamar Sekarang
                        </a>

                    </div>
                </div>
            </div>

        </div>

        <hr class="my-5">

        {{-- CONTENT --}}
        <div class="row">

            {{-- PERSYARATAN --}}
            <div class="col-md-6">
                <h5 class="fw-bold mb-3">Persyaratan</h5>
                <ul class="job-list">
                    <li>Kerja di kantor</li>
                    <li>Minimal SMA/SMK</li>
                    <li>Usia 18 – 30 tahun</li>
                    <li>Perempuan saja</li>
                </ul>
            </div>

            {{-- SKILLS --}}
            <div class="col-md-6">
                <h5 class="fw-bold mb-3">Skills</h5>
                <ul class="job-list">
                    <li>Data Entry</li>
                    <li>Customer Service</li>
                    <li>Office Administration</li>
                </ul>
            </div>

        </div>

    </div>
</section>

@endsection
