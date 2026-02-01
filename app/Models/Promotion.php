<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = ['name', 'description', 'price', 'image_path', 'status', 'discount_percent'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_promotion');
    }
}
