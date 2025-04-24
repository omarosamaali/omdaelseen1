<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Explorers extends Model
{
    protected $table = 'explorers';

    protected $fillable = [
        'name_ar',
        'name_en',
        'name_ch',
        'avatar',
        'status',
    ];

    // Define the relationship with Places
    public function places()
    {
        return $this->hasMany(Places::class, 'main_category_id', 'id');
    }

    // Optionally, add a method to get the count of places
    public function getPlacesCountAttribute()
    {
        return $this->places()->count();
    }
}