<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'phone',
        'email',
        'country',
        'role',
        'status',
        'password',
        'avatar',
        'otp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Define the relationship with Places.
     */
    public function places()
    {
        return $this->hasMany(Places::class, 'user_id', 'id');
    }

    /**
     * Get the count of places as an attribute.
     */
    public function getPlacesCountAttribute()
    {
        return $this->places()->count();
    }
}
