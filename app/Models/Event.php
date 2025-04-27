<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'title_zh',
        'description_ar',
        'description_en',
        'description_zh',
        'start_date',
        'end_date',
        'type',
        'status',
        'avatar',
        'region_id'
    ];

    public function region()
    {
        return $this->belongsTo(Regions::class, 'region_id');
    }
}