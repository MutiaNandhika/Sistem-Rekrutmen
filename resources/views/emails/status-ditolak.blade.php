@extends('emails.layout')

@section('content')
<div class="header">
    Informasi Hasil Lamaran
</div>

<p>
    Halo <strong>{{ $application->user->name }}</strong>,
</p>

<p>
    Terima kasih atas ketertarikan dan waktu yang telah kamu luangkan
    untuk melamar posisi
    <strong>{{ $application->lowongan->nama_lowongan }}</strong>
    di <strong>MDA Partner</strong>.
</p>

<p>
    Setelah melalui proses seleksi dan pertimbangan yang matang,
    dengan berat hati kami sampaikan bahwa
    <strong>lamaran kamu belum dapat kami lanjutkan ke tahap berikutnya</strong>.
</p>

<p>
    Keputusan ini tidak mencerminkan kemampuan atau potensi kamu secara keseluruhan,
    melainkan disesuaikan dengan kebutuhan dan kriteria perusahaan saat ini.
</p>

<p>
    Kami sangat menghargai usaha dan minat kamu, serta mendoakan
    kesuksesan kamu pada kesempatan karier selanjutnya.
</p>

<p>
    Terima kasih atas kepercayaan kamu kepada <strong>MDA Partner</strong>.
</p>

<p>
    Salam hormat,<br>
    <strong>Tim HRD MDA Partner</strong>
</p>
@endsection
