<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TripRequest;

class NewTrip extends Mailable
{
    use Queueable, SerializesModels;

    public $tripRequest;

    /**
     * إنشاء كائن المراسلة
     */
    public function __construct(TripRequest $tripRequest)
    {
        $this->tripRequest = $tripRequest;
    }

    /**
     * بناء رسالة البريد الإلكتروني
     */
    public function build()
    {
        return $this->subject('تم استلام طلب رحلة جديد - ' . $this->tripRequest->reference_number)
            ->view('emails.new-trip')
            ->with([
                '' => $this->tripRequest,
                'user' => $this->tripRequest->user
            ]);
    }
}
