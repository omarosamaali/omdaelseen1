<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelChat extends Model
{
    protected $fillable = ['trip_id', 'user_id', 'message', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
