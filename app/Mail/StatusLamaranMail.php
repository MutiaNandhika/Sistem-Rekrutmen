<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class StatusLamaranMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application->load(['user', 'lowongan']);
    }

    public function build()
{
    // jika status ditolak → pakai email khusus
    if (in_array($this->application->status, [
        'ditolak',
        'ditolak_administrasi',
        'tidak_lolos_saw'
    ])) {
        return $this->subject(
            'Informasi Hasil Lamaran – ' . $this->application->lowongan->nama_lowongan
        )
        ->view('emails.status-ditolak')
        ->with([
            'application' => $this->application
        ]);
    }

    return $this->subject(
        'Update Status Lamaran – ' . $this->application->lowongan->nama_lowongan
    )
    ->view('emails.status-lamaran')
    ->with([
        'application' => $this->application
    ]);
}

}
