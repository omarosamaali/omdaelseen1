<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripMessage extends Model
{
    use HasFactory;

    protected $fillable = ['trip_request_id', 'sender_id', 'message'];

    public function trip()
    {
        return $this->belongsTo(TripRequest::class, 'trip_request_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function getIsAdminAttribute()
    {
        return $this->sender && $this->sender->role === 'admin';
    }
}
