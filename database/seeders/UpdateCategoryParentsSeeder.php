<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class UpdateCategoryParentsSeeder extends Seeder
{
    public function run()
    {
        // 1. Reset all parents to null first to ensure clean state
        Category::query()->update(['parent' => null]);

        // 2. Beverages Map
        Category::whereIn('name', ['Hot Drinks', 'Cold Drinks'])->update(['parent' => 'Beverages']);

        // 3. Food Map
        Category::whereIn('name', ['Breakfast', 'Lunch', 'Dinner', 'Snacks', 'Desserts'])->update(['parent' => 'Food']);
    }
}
