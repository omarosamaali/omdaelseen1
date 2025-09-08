<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Followers extends Model
{
    use HasFactory;

    protected $table = 'followers';

    protected $fillable = [
        'follower_id',
        'following_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // إضافة index مركب لمنع التكرار
    public $incrementing = true;
    protected $primaryKey = 'id';

    // علاقات النموذج
    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function following(): BelongsTo
    {
        return $this->belongsTo(User::class, 'following_id');
    }

    // قواعد التحقق
    public static function rules(): array
    {
        return [
            'follower_id' => 'required|exists:users,id',
            'following_id' => 'required|exists:users,id|different:follower_id',
        ];
    }

    // إضافة scope للبحث
    public function scopeByFollower($query, $followerId)
    {
        return $query->where('follower_id', $followerId);
    }

    public function scopeByFollowing($query, $followingId)
    {
        return $query->where('following_id', $followingId);
    }
}
