<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInterest extends Model
{
    protected $fillable = ['user_id', 'interest_type', 'interest_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Dynamically resolve the related interest based on type
public function interest()
{
    if (!$this->interest_type) {
        return null;
    }
    
    switch ($this->interest_type) {
        case 'event':
            return $this->belongsTo(Event::class, 'interest_id');
        case 'help_word':
            return $this->belongsTo(HelpWord::class, 'interest_id');
        default:
            return null;
    }
}

public function event()
{
    return $this->belongsTo(Event::class, 'interest_id');
}

public function help_word()
{
    return $this->belongsTo(HelpWord::class, 'interest_id');
}
    // Get a display-friendly interest type name
    public function getInterestTypeNameAttribute()
    {
        if ($this->interest_type === 'help_word') {
            return 'كلمة مساعدة';
        }

        if ($this->interest_type === 'event' && $this->interest) {
            return $this->interest->type === 'معرض' ? 'معرض' : 'مناسبة';
        }

        return 'غير معروف';
    }
}