<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'reference_number',
        'number_of_products',
        'price_unexpected',
        'item_unavailable',
        'no_returns',
        'no_problem',
        'same_company',
        'batteries',
        'see_product',
    ];

    /**
     * Get the user that owns the product.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'order_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'order_id', 'id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'order');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'order');
    }

    // تغيير العلاقة من morphMany إلى hasMany
    public function order_messages()
    {
        return $this->hasMany(OrderMessage::class, 'product_id', 'id');
    }
}
