<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewReport extends Model
{
    protected $fillable = ['user_id', 'place_id', 'review_id', 'report_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function place()
    {
        return $this->belongsTo(Places::class);
    }

    public function rating()
    {
        return $this->belongsTo(Rating::class, 'review_id');
    }
}
