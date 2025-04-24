<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
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
