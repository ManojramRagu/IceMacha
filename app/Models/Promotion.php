<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'discount_percent', 'image_path'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_promotion');
    }
}
