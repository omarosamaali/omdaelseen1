<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpWord extends Model
{
    use HasFactory;

    protected $fillable = [
        'word_ar', 'word_en', 'word_zh',
        'status', 'order'
    ];
}