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
        // Cache the paginated results for 60 seconds
        $page = request('page', 1);
        $products = Cache::remember('api_products_page_' . $page, 60, function () {
            return Product::paginate(10);
        });

        return ProductResource::collection($products);
    }

    /**
     * Display top selling products.
     */
    public function topSelling()
    {
        $products = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        return ProductResource::collection($products);
    }

    /**
     * Display trending products (Most Stocked).
     */
    public function trending()
    {
        $products = Product::orderBy('stock_quantity', 'desc')
            ->take(5)
            ->get();

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
