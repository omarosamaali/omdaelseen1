<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    protected $table = 'branches';

    protected $fillable = [
        'name_ar',
        'name_en',
        'name_ch',
        'avatar',
        'status',
        'main',
        'parent_id',
    ];

    public function places()
    {
        return $this->hasMany(Places::class, 'sub_category_id', 'id');
    }

    public function getPlacesCountAttribute()
    {
        return $this->places()->count();
    }

    public function explorer()
    {
        return $this->belongsTo(Explorers::class, 'main', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Branches::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Branches::class, 'parent_id');
    }
}