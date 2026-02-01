<?php

use App\Models\Product;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Creating Category Manually...\n";
    $c = \App\Models\Category::create(['name' => 'Cat', 'description' => 'Desc']);
    echo "Category Created: " . $c->id . "\n";

    echo "Creating Product Manually...\n";
    $p = Product::create([
        'name' => 'Man',
        'description' => 'Desc',
        'price' => 10,
        'image_path' => 'img.jpg',
        'category_id' => $c->id,
        'status' => 'active',
        'stock_quantity' => 50
    ]);
    echo "Product Created: " . $p->id . "\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
