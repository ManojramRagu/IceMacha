<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    private function createCategory()
    {
        return Category::create([
            'name' => 'Cat ' . uniqid(),
            'description' => 'Desc'
        ]);
    }

    private function createProduct($overrides = [])
    {
        $category = isset($overrides['category_id']) ? Category::find($overrides['category_id']) : $this->createCategory();
        
        return Product::create(array_merge([
            'name' => 'Prod ' . uniqid(),
            'description' => 'Desc',
            'price' => 50,
            'image_path' => 'img.jpg',
            'category_id' => $category->id,
            'status' => 'active',
            'stock_quantity' => 10
        ], $overrides));
    }

    public function test_can_list_products_publicly()
    {
        for ($i = 0; $i < 15; $i++) {
            $this->createProduct();
        }

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => ['id', 'name', 'price']
                    ]
                ]
            ]);
    }

    public function test_can_filter_products_by_category()
    {
        $category = $this->createCategory();
        $this->createProduct(['category_id' => $category->id]);
        $this->createProduct(); // different category

        $response = $this->getJson('/api/products?category_id=' . $category->id);

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data.data'));
    }

    public function test_cannot_create_product_without_token()
    {
        $response = $this->postJson('/api/products', [
            'name' => 'New Product',
            'price' => 100
        ]);
        
        $response->dump();

        $response->assertStatus(401); // Unauthorized
    }

    public function test_can_create_product_with_token()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test'.uniqid().'@example.com',
            'password' => bcrypt('password')
        ]);
        
        $category = $this->createCategory();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/products', [
            'name' => 'New Product',
            'description' => 'Test Desc',
            'price' => 100,
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'image' => null // Optional validation check
        ]);

        $response->assertStatus(201)
            ->assertJson(['status' => 'success']);
            
        $this->assertDatabaseHas('products', ['name' => 'New Product']);
    }

    public function test_api_returns_standard_error_format()
    {
        $user = User::create([
            'name' => 'Test User 2',
            'email' => 'test2'.uniqid().'@example.com',
            'password' => bcrypt('password')
        ]);
        
        // Sending invalid data to trigger validation error
        $response = $this->actingAs($user, 'sanctum')->postJson('/api/products', [
            'name' => '', // Required
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['status', 'message', 'data']);
            
        $this->assertEquals('error', $response->json('status'));
    }
}
