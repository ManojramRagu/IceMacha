<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Promotion;
use App\Models\Product;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        $promotionsPath = public_path('img/products/Promotions');

        if (!File::exists($promotionsPath)) {
             $this->command->warn("Promotions directory not found at $promotionsPath");
             return;
        }

        $files = File::files($promotionsPath);

        foreach ($files as $file) {
            $filename = $file->getFilename();
            $name = pathinfo($filename, PATHINFO_FILENAME); // e.g., "Coffee Lovers"
            $displayName = str_replace('-', ' ', $name);
            $relativePath = 'img/products/Promotions/' . $filename;

            $this->command->info("Creating Promotion: $displayName");

            $promotion = Promotion::updateOrCreate(
                ['name' => $displayName],
                [
                    'description' => "Special bundle: $displayName",
                    'price' => 1500.00, // Default bundle price
                    'image_path' => $relativePath,
                    'status' => 'active'
                ]
            );

            // Attach random products for realism (3 items)
            // In a real app, these would be specific, but randomized valid products works for visual demo
            if (Product::count() > 0) {
                $randomProducts = Product::inRandomOrder()->take(3)->pluck('id');
                $promotion->products()->sync($randomProducts);
            }
        }
    }
}
