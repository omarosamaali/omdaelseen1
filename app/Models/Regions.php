<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    protected $table = 'regions';

    protected $fillable = [
        'name_ar',
        'name_en',
        'name_ch',
        'avatar',
        'status',
    ];

    public function places()
    {
        return $this->hasMany(Places::class, 'region_id', 'id');
    }

    public function getPlacesCountAttribute()
    {
        return $this->places()->count();
    }
}
