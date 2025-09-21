<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'date',
        'period',
        'image',
        'status',
        'is_place_related',
        'place_id',
        'place_name_ar',
        'place_name_en',
        'place_name_zh',
        'details_ar',
        'details_en',
        'details_zh',
    ];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(Places::class, 'place_id'); // إذا كان اسم النموذج Place
    }


    public function subCategory()
    {
        return $this->belongsTo(Branches::class);
    }
}
