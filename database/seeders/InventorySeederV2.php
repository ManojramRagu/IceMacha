<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;

class InventorySeederV2 extends Seeder
{
    public function run(): void
    {
        try {
            $this->command->info("InventorySeederV2 started.");
            $productsPath = public_path('img/products');
            $this->command->info("Checking path: $productsPath");

            if (!File::exists($productsPath)) {
                $this->command->error("Directory does not exist: $productsPath");
                return;
            }

            $mainCategories = File::directories($productsPath);

            foreach ($mainCategories as $categoryDir) {
                $categoryName = basename($categoryDir);
                
                if ($categoryName === 'Promotions') {
                    continue;
                }

                $this->command->info("Processing Category: $categoryName");

                $category = Category::firstOrCreate(
                    ['name' => $categoryName],
                    ['description' => "Delicious $categoryName"]
                );

                $subCategories = File::directories($categoryDir);

                foreach ($subCategories as $subCategoryDir) {
                    $subCategoryName = basename($subCategoryDir);
                    $this->command->info("  Processing SubCategory: $subCategoryName");

                    $subCategory = SubCategory::firstOrCreate(
                        [
                            'name' => $subCategoryName,
                            'category_id' => $category->id
                        ],
                        ['description' => "$subCategoryName items under $categoryName"]
                    );

                    $files = File::files($subCategoryDir);

                    foreach ($files as $file) {
                        $filename = $file->getFilename();
                        $productName = pathinfo($filename, PATHINFO_FILENAME);
                        $displayName = str_replace('-', ' ', $productName);
                        $relativePath = 'img/products/' . $categoryName . '/' . $subCategoryName . '/' . $filename;

                        $this->command->info("    Creating Product: $displayName");

                        Product::updateOrCreate(
                            ['name' => $displayName],
                            [
                                'description' => "Freshly prepared $displayName.",
                                'price' => 500.00, // Hardcoded for simplicity/robustness
                                'image_path' => $relativePath,
                                'category_id' => $category->id,
                                'sub_category_id' => $subCategory->id,
                                'status' => 'active',
                                'stock_quantity' => 50
                            ]
                        );
                    }
                }
            }
        } catch (\Exception $e) {
            $this->command->error("Error in InventorySeederV2: " . $e->getMessage());
            $this->command->error($e->getTraceAsString());
        }
    }
}
