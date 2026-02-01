<?php

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProductController;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Creating Products...\n";
    Product::withoutEvents(function () {
        Product::factory()->count(5)->create();
    });
    
    echo "Products Created. Count: " . Product::count() . "\n";
    
    $controller = new ProductController();
    $request = Request::create('/api/products', 'GET');
    
    echo "Calling Index...\n";
    $response = $controller->index($request);
    
    echo "Response Status: " . $response->getStatusCode() . "\n";
    echo "Response Content: " . substr($response->getContent(), 0, 100) . "...\n";
    
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
