<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TripFeature;

class Trip extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trips';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title_ar',
        'title_en',
        'title_ch',
        'departure_date',
        'return_date',
        'hotel_ar',
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
        'factory_visit',
        'tourist_sites_visit',
        'markets_visit',
        'tickets_included',
        'price',
        'status',
        'trip_features',
        'trip_guidelines',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meals' => 'array',
        'departure_date' => 'date',
        'return_date' => 'date',
        'airport_pickup' => 'boolean',
        'supervisor' => 'boolean',
        'factory_visit' => 'boolean',
        'tourist_sites_visit' => 'boolean',
        'markets_visit' => 'boolean',
        'tickets_included' => 'boolean',
    ];

    public function features()
    {
        return $this->belongsToMany(TripFeature::class, 'trip_feature', 'trip_id', 'feature_id');
    }

    public function guidelines()
    {
        return $this->belongsToMany(TripGuideline::class, 'trip_guideline', 'trip_id', 'guideline_id');
    }
}
