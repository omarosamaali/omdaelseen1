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
    ];
}
