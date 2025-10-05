<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;

class NewProductOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $productOrder;

    public function __construct(Product $productOrder)
    {
        $this->productOrder = $productOrder;
    }

    public function build()
    {
        return $this->subject('🛒 طلب منتجات جديد من عميل')
            ->view('emails.new-product-order')
            ->with(['productOrder' => $this->productOrder]);
    }
}
