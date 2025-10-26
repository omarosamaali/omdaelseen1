<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelChat extends Model
{
    protected $fillable = [
        'trip_id',
        'order_id',
        'order_type',
        'user_id',
        'message',
        'image',
    ];

    // Polymorphic Relationship
    public function order()
    {
        return $this->morphTo('order', 'order_type', 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}