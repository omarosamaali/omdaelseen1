<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_id',
        'room_type',
        'amount',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
