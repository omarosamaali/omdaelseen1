<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'trip_id',
        'user_id',
        'booking_date',
        'order_type',
        'destination',
        'customer_name',
        'status',
        'amount',
        'payment_intent_id',
        'payment_status',
        'payment_data',
        'order_number',
        'payment_gateway_fee', // ✅ ضيف العمود هنا

    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'payment_data' => 'array',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
