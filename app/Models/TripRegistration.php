<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_id',
        'room_type',
        'amount',
        'status',
        'reference_number'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * العلاقة مع جدول المستخدمين
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes مفيدة

    /**
     * الطلبات المعلقة فقط
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * الطلبات المقبولة فقط
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * الطلبات المرفوضة فقط
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * طلبات مستخدم معين
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * طلبات رحلة معينة
     */
    public function scopeForTrip($query, $tripId)
    {
        return $query->where('trip_id', $tripId);
    }

    // Helper Methods

    /**
     * تحقق إذا كان الطلب معلق
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * تحقق إذا كان الطلب مقبول
     */
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    /**
     * تحقق إذا كان الطلب مرفوض
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * قبول الطلب
     */
    public function paid()
    {
        $this->update(['status' => 'paid']);
    }

    /**
     * رفض الطلب
     */
    public function reject()
    {
        $this->update(['status' => 'rejected']);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'order_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'order_id', 'id');
    }

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'order');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'order');
    }

    public function order_messages()
    {
        return $this->hasMany(OrderMessage::class, 'product_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(TripMessage::class);
    }
}
