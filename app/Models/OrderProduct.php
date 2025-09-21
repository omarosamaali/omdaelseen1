<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'link',
        'quantity',
        'price',
        'size',
        'color',
        'notes',
        'images',
        
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
