<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ProductController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Product::query();

            // Filter by Category
            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            // Filter by Status (assuming 'is_active' or similar, defaulting to showing all for now unless specified)
            // Example: ?status=active
            if ($request->has('status') && $request->status === 'active') {
                 // Adjust column name if needed, e.g., 'is_active' or 'stock' > 0
            }

            // Pagination (10 per page)
            $products = $query->paginate(10);

            return ProductResource::collection($products)->additional([
                'status' => 'success',
                'message' => 'Products retrieved successfully.'
            ])->response()->setStatusCode(200);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve products: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'stock_quantity' => 'required|integer|min:0',
                'image' => 'nullable|image|max:2048', // Validation specific to file uploads handled elsewhere usually, but generic here
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 422);
            }

            $data = $request->except(['image']);
            
            // Handle Image Upload
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $data['image_path'] = 'storage/' . $path;
            } else {
                // Default image or required error if not in dev
                // For simplicity in this assignment, we use a placeholder if not provided
                $data['image_path'] = 'storage/products/default.jpg';
            }

            $product = Product::create($data);

            return (new ProductResource($product))->additional([
                'status' => 'success',
                'message' => 'Product created successfully.'
            ])->response()->setStatusCode(201);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to create product: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return $this->errorResponse('Product not found.', 404);
            }

            return (new ProductResource($product))->additional([
                'status' => 'success',
                'message' => 'Product retrieved successfully.'
            ])->response()->setStatusCode(200);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve product: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return $this->errorResponse('Product not found.', 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'price' => 'sometimes|numeric|min:0',
                'category_id' => 'sometimes|exists:categories,id',
                'stock_quantity' => 'sometimes|integer|min:0',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 422);
            }

            $data = $request->except(['image']);

            if ($request->hasFile('image')) {
                // Delete old image if needed (omitted for brevity)
                $path = $request->file('image')->store('products', 'public');
                $data['image_path'] = 'storage/' . $path;
            }

            $product->update($data);

            return (new ProductResource($product))->additional([
                'status' => 'success',
                'message' => 'Product updated successfully.'
            ])->response()->setStatusCode(200);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to update product: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return $this->errorResponse('Product not found.', 404);
            }

            $product->delete();

            return $this->successResponse(null, 'Product deleted successfully.');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to delete product: ' . $e->getMessage(), 500);
        }
    }
}
