<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'travelers_count',
        'interests',
        'user_id',
    ];

    protected $casts = [
        'interests' => 'array',
    ];

    public function travel_chats()
    {
        return $this->hasMany(TravelChat::class, 'trip_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'order_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'order_id', 'id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'order');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'order');
    }

    // تغيير العلاقة من morphMany إلى hasMany
    public function order_messages()
    {
        return $this->hasMany(OrderMessage::class, 'product_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(TripMessage::class);
    }
}
