@extends('layouts.public')

@section('title', 'Profil Saya')

@section('content')

<div class="profile-page container py-4">

    {{-- ================= HEADER ACTION ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Profil Saya</h4>

        <a href="{{ route('cv.download', auth()->id()) }}"
           target="_blank"
           class="btn btn-primary">
            <i class="bi bi-file-earmark-pdf"></i> Download CV
        </a>
    </div>

    {{-- ================= PROFILE HEADER ================= --}}
    @include('pelamar.profile.sections.header')

    <hr>

    {{-- ================= ABOUT ================= --}}
    @include('pelamar.profile.sections.about')

    <hr>

    {{-- ================= EXPERIENCE ================= --}}
    @include('pelamar.profile.sections.experiences')

    <hr>

    {{-- ================= EDUCATION ================= --}}
    @include('pelamar.profile.sections.educations')

    <hr>

    {{-- ================= SKILLS ================= --}}
    @include('pelamar.profile.sections.skills')

    <hr>

    {{-- ================= RESUME ================= --}}
    @include('pelamar.profile.sections.resume')

    <hr>

    {{-- ================= ACHIEVEMENTS ================= --}}
    @include('pelamar.profile.sections.achievements')

    <hr>

    {{-- ================= CERTIFICATES ================= --}}
    @include('pelamar.profile.sections.certificates')

    <hr>

    {{-- ================= ORGANIZATIONS ================= --}}
    @include('pelamar.profile.sections.organizations')

</div>


{{-- ================= MODALS ================= --}}
@include('pelamar.profile.modals.data-diri')
@include('pelamar.profile.modals.tentang-saya')
@include('pelamar.profile.modals.pengalaman')
@include('pelamar.profile.modals.pendidikan')
@include('pelamar.profile.modals.skills')
@include('pelamar.profile.modals.resume')
@include('pelamar.profile.modals.penghargaan')
@include('pelamar.profile.modals.sertifikat')
@include('pelamar.profile.modals.organisasi')

@endsection
