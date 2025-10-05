<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpWord extends Model
{
    use HasFactory;

    protected $fillable = [
        'word_ar',
        'word_en',
        'word_zh',
        'audio_zh',
        'status',
        'order',
        'word_type',
    ];

    public function getTranslatedWordAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'en' && !empty($this->word_en)) {
            return $this->word_en;
        } elseif ($locale === 'zh' && !empty($this->word_zh)) {
            return $this->word_zh;
        }
        return $this->word_ar ?? 'No word available';
    }
}
