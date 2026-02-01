<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "saved" event.
     */
    public function saved(Category $category): void
    {
        \Illuminate\Support\Facades\Cache::forget('menu_categories');
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        \Illuminate\Support\Facades\Cache::forget('menu_categories');
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        \Illuminate\Support\Facades\Cache::forget('menu_categories');
    }
}
