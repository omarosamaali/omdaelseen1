<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $placeName;

    public function __construct($userName, $placeName)
    {
        $this->userName = $userName;
        $this->placeName = $placeName;
    }

    public function build()
    {
        return $this->subject('عمدة الصين | بلاغ عن ' . $this->placeName)
            ->view('emails.report_user');
    }
}
