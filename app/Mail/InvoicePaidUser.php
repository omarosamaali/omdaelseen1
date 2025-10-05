<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Invoice;

class InvoicePaidUser extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function build()
    {
        return $this->subject('تم دفع الفاتورة بنجاح - Invoice Paid Successfully')
            ->view('emails.invoice-paid-user')
            ->with([
                'invoice' => $this->invoice,
                'user' => $this->invoice->user
            ]);
    }
}
