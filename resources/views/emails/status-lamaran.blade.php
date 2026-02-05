@extends('emails.layout')

@section('content')
<div class="header">
    Update Status Lamaran
</div>

<p>Halo <strong>{{ $application->user->name }}</strong>,</p>

<p>
    Status lamaran kamu untuk posisi
    <strong>{{ $application->lowongan->nama_lowongan }}</strong>
    telah diperbarui.
</p>

<p>
    Status terbaru:
    <br><br>
    <span class="badge">
        {{ strtoupper(str_replace('_',' ', $application->status)) }}
    </span>
</p>

<p>
    Silakan login ke akun kamu untuk melihat detail perkembangan lamaran.
</p>

<p>
    Salam,<br>
    <strong>Tim HRD MDA Partner</strong>
</p>
@endsection
