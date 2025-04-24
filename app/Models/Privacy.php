<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privacy extends Model
{
    protected $table = 'privacy';
    protected $fillable = [
    'content_ar',
    'content_en',
    'content_zh',
    'title_ar',
    'title_en',
    'title_zh',
    'avatar',
    'status',
];
}
