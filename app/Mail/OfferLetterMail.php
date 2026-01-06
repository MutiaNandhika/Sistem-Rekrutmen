<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferLetterMail extends Mailable
{
    public Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function build()
    {
        return $this->subject(
            'Offering Kerja – ' . $this->application->lowongan->nama_lowongan
        )
        ->view('emails.offer-letter')
        ->with([
            'application' => $this->application
        ]);
    }
}

