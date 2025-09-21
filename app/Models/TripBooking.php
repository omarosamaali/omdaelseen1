<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripBooking extends Model
{
    protected $fillable = [
        'trip_id',
        'user_id',
        'payment_intent_id',
        'amount',
        'status',
        'payment_status',
        'payment_details'
    ];

    protected $casts = [
        'payment_details' => 'array',
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
