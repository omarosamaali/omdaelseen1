<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'order_type',
        'amount',
        'currency',
        'payment_reference',
        'status',
        'payment_method',
        'gateway_response',
        'reference_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function order()
    {
        return $this->belongsTo(Adds::class, 'order_id');
    }
}
