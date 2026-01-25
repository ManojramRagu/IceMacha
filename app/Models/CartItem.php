<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cartitems';
    protected $primaryKey = 'CartItemId';
    public $timestamps = false;

    protected $fillable = [
        'CartId',
        'ProductId',
        'PromotionId',
        'Quantity',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'ProductId', 'id');
    }

    public function cart() {
        return $this->belongsTo(Cart::class, 'CartId', 'CartId');
    }
}
