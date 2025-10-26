<?php

// app/Models/Adds.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adds extends Model
{
    protected $fillable = [
        'type_ar',
        'type_en',
        'type_zh',
        'details_ar',
        'details_en',
        'details_zh',
        'price',
        'status',
        'image',

    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id');
    }
}