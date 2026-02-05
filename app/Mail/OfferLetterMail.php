<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class OfferLetterMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }
    public function build()
    {
        return $this->subject(
            'OFFICIAL JOB OFFER – ' . $this->application->lowongan->nama_lowongan
        )
        ->view('emails.offer-letter')
        ->with([
            'application' => $this->application
        ]);
    }

}

