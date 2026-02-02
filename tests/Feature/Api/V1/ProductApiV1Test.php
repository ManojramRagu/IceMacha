<?php

namespace Tests\Feature\Api\V1;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductApiV1Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_v1_index_returns_paginated_products()
    {
        $category = Category::factory()->create();
        Product::factory()->count(15)->create([
            'category_id' => $category->id
        ]);

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'name', 'price', 'category_id', 'status'
                    ]
                ],
                'meta' => [
                    'current_page', 'last_page', 'per_page', 'total'
                ],
                'links'
            ]);
            
        // Assert pagination limit (10 per page)
        $this->assertCount(10, $response->json('data'));
    }

    public function test_v1_product_resource_hides_timestamps()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id
        ]);

        $response = $this->getJson("/api/v1/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJsonMissing(['created_at', 'updated_at', 'deleted_at'])
            ->assertJsonFragment(['name' => $product->name]);
    }

    public function test_unauthorized_access_returns_standardized_json_error()
    {
        // Try to logout without token to trigger authentication exception behavior? 
        // Or access a protected route without token.
        // Let's try cart route which is protected.
        
        $response = $this->postJson('/api/cart', []);

        $response->assertStatus(401)
            ->assertExactJson(['error' => 'Unauthorized Access']);
    }

    public function test_not_found_returns_standardized_json_error()
    {
        $response = $this->getJson('/api/v1/products/999999');

        $response->assertStatus(404)
            ->assertExactJson([
                'status' => 'error',
                'message' => 'Resource not found'
            ]);
    }
    
    public function test_cart_management_requires_scope()
    {
        $user = User::factory()->create();
        
        // Token WITHOUT cart:manage
        Sanctum::actingAs($user, ['products:read']);
        
        $response = $this->postJson('/api/cart', []);
        
        // Should be forbidden by abilities middleware
        $response->assertStatus(403);
    }
    
    public function test_cart_management_allows_scope()
    {
        $user = User::factory()->create();
        
        // Token WITH cart:manage
        Sanctum::actingAs($user, ['cart:manage']);
        
        $response = $this->postJson('/api/cart', []);
        
        $response->assertStatus(200)
            ->assertJson(['message' => 'Item added to cart']);
    }
}
