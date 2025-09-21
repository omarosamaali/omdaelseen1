<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'note_number',
        'order_id',
        'order_type',
        'note_date',
        'title',
        'details',
        'file_path',
        'status',
        'user_id',
    ];

    public function order()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
