<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    protected $fillable = [
        'user_id',
        'name_ar',
        'name_en',
        'name_ch',
        'main_category_id',
        'sub_category_id',
        'region_id',
        'link',
        'map_type',
        'avatar',
        'additional_images',
        'phone',
        'email',
        'details_ar',
        'details_en',
        'details_ch',
        'website',
        'status',
    ];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Optional: you can add a relationship to get the average rating
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
    
    public function favortiedByUsers(){
        return $this->belongsToMany(User::class, 'favorites', 'place_id', 'user_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'place_id', 'user_id');
    }

    public function mainCategory()
    {
        return $this->belongsTo(Explorers::class, 'main_category_id', 'id');
    }
    

    public function subCategory()
    {
        return $this->belongsTo(Branches::class, 'sub_category_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo(Regions::class);
    }
}