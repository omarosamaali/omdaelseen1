<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'approval_number',
        'order_id',
        'order_type',
        'approval_date',
        'user_id',
        'title',
        'details',
        'file_path',
        'status',
        'trip_id',
    ];

    public function order()
    {
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
