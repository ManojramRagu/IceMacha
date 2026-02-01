<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'image_path', 
        'category_id', 
        'sub_category_id', 
        'status', 
        'stock_quantity'
    ];

    protected static function booted(): void
    {
        static::observe(\App\Observers\ProductObserver::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    
    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'product_promotion');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'active')->where('stock_quantity', '>', 0);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rs. ' . number_format($this->price, 2);
    }
}
