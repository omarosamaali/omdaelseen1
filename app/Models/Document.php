<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_number',
        'order_id',
        'order_type',
        'document_date',
        'title',
        'details',
        'file_path',
        'user_id',
        'trip_id',
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
