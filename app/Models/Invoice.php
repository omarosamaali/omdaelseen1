<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'order_id',
        'user_id',
        'order_type',
        'invoice_date',
        'title',
        'amount',
        'payment_intent_id',
        'paid_at',
        'status',
    ];

    public function order()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}
