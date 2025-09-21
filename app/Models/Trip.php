<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trips';

    protected $fillable = [
        'title_ar',
        'title_en',
        'title_ch',
        'departure_date',
        'return_date',
        'hotel_ar',
        'reference_number',
        'hotel_en',
        'hotel_ch',
        'transportation_type',
        'trip_type',
        'room_type',
        'shared_room_price',
        'private_room_price',
        'translators',
        'meals',
        'airport_pickup',
        'supervisor',
        'image',
        'factory_visit',
        'tourist_sites_visit',
        'markets_visit',
        'tickets_included',
        'price',
        'status',
        'trip_features',
        'trip_guidelines',
    ];

    protected $casts = [
        'meals' => 'array',
        'trip_features' => 'array',
        'trip_guidelines' => 'array',
        'departure_date' => 'date',
        'return_date' => 'date',
        'airport_pickup' => 'boolean',
        'supervisor' => 'boolean',
        'factory_visit' => 'boolean',
        'tourist_sites_visit' => 'boolean',
        'markets_visit' => 'boolean',
        'tickets_included' => 'boolean',
    ];

    public function activities()
    {
        return $this->hasMany(TripActivity::class);
    }

    public function subCategory(){
        return $this->belongsTo(Branches::class);
    }

    public function getTranslatedTripTypeAttribute()
    {
        return __('messages.' . $this->trip_type);
    }
}