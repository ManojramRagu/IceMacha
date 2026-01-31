<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            InventorySeederV2::class,
            PromotionSeeder::class,
            UserSeeder::class,
        ]);
    }
}
