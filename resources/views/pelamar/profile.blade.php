@extends('layouts.public')

@section('title', 'Profile Saya')

@section('content')

{{-- ================= SECTION ================= --}}
    @include('pelamar.profile.sections.header')
    @include('pelamar.profile.sections.about')
    @include('pelamar.profile.sections.experiences')
    @include('pelamar.profile.sections.educations')
    @include('pelamar.profile.sections.skills')
    @include('pelamar.profile.sections.resume')
    @include('pelamar.profile.sections.achievements')
    @include('pelamar.profile.sections.certificates')
    @include('pelamar.profile.sections.organizations')

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

