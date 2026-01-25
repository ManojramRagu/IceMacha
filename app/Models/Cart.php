<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'CartId';
    public $timestamps = false;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = null;

    protected $fillable = ['UserId'];

    public function items() {
        return $this->hasMany(CartItem::class, 'CartId', 'CartId');
    }
}
