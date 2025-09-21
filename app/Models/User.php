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
        'explorer_name',
        'otp',
    ];

    public function tripRequests()
    {
        return $this->hasMany(TripRequest::class);
    }


    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorites::class);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // App/Models/User.php


    public function following()
    {
        // المستخدم الذي يتابع
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id');
    }
    // في User.php model

    public function followings()
    {
        return $this->hasMany(Followers::class, 'following_id');
    }
    public function followers()
    {
        // المستخدم الذي يتم متابعته
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id');
    }

    // دالة مساعدة للتحقق من المتابعة
    public function isFollowing(User $user): bool
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }
    public function favoritePlaces()
    {
        return $this->belongsToMany(Places::class, 'favorites', 'user_id', 'place_id');
    }
    public function isFavorite(Places $place)
    {
        // The `where()` method filters the relationship results.
        // The `exists()` method efficiently checks if any record matches without fetching all data.
        return $this->favoritePlaces()->where('place_id', $place->id)->exists();
    }
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
