<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Invoice;

class InvoicePaidAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    /**
     * إنشاء كائن المراسلة
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * بناء رسالة البريد الإلكتروني
     */
    public function build()
    {
        return $this->subject('تم استلام دفعة جديدة - New Invoice Payment Received')
            ->view('emails.invoice-paid-admin')
            ->with([
                'invoice' => $this->invoice,
                'user' => $this->invoice->user
            ]);
    }
}
