<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductApiController extends Controller
{
    /**
     * Display a paginated list of products.
     */
    public function index()
    {
        // Cache the paginated results for 10 minutes (600 seconds)
        $products = \Illuminate\Support\Facades\Cache::remember('products_api_index', 600, function () {
            return Product::paginate(10);
        });

        return ProductResource::collection($products);
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }
}
