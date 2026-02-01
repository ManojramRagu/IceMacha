<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the Product "saved" event.
     */
    public function saved(Product $product): void
    {
        \Illuminate\Support\Facades\Cache::forget('menu_categories');
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        \Illuminate\Support\Facades\Cache::forget('menu_categories');
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        \Illuminate\Support\Facades\Cache::forget('menu_categories');
    }
}
