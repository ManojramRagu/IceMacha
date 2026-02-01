<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    private function createCategory()
    {
        return Category::create([
            'name' => 'Category ' . uniqid(),
            'description' => 'Description'
        ]);
    }

    public function test_admin_gets_admin_abilities()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->createAdminUser()->email,
            'password' => 'password',
            'device_name' => 'test-device'
        ]);

        $response->assertStatus(200)
            ->assertJson(['abilities' => ['admin:all']]);
    }

    public function test_regular_user_gets_limited_abilities()
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->createRegularUser()->email,
            'password' => 'password',
            'device_name' => 'test-device'
        ]);

        $response->assertStatus(200)
            ->assertJson(['abilities' => ['products:read', 'cart:write']]);
    }

    public function test_admin_can_access_protected_routes()
    {
        $admin = $this->createAdminUser();
        $category = $this->createCategory();

        Sanctum::actingAs($admin, ['admin:all']);

        $response = $this->postJson('/api/products', [
                'name' => 'Admin Product',
                'description' => 'Description',
                'price' => 100,
                'stock_quantity' => 10,
                'category_id' => $category->id
            ]);

        $response->assertStatus(201);
    }

    public function test_regular_user_cannot_access_admin_routes()
    {
        $user = $this->createRegularUser();
        $category = $this->createCategory();

        Sanctum::actingAs($user, ['products:read', 'cart:write']);

        $response = $this->postJson('/api/products', [
                'name' => 'User Product',
                'description' => 'Description',
                'price' => 100,
                'stock_quantity' => 10,
                'category_id' => $category->id
            ]);

        $response->assertStatus(403); // Forbidden
    }

    public function test_logout_revokes_current_token()
    {
        $user = $this->createRegularUser();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/logout');

        $response->assertStatus(200);
        $this->assertEquals(0, $user->tokens()->count());
    }

    public function test_unauthorized_access_returns_standard_response()
    {
        $response = $this->postJson('/api/logout'); // No token

        $response->assertStatus(401)
            ->assertJson(['error' => 'Unauthorized Access']);
    }

    private function createAdminUser()
    {
        return User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
    }

    private function createRegularUser()
    {
        return User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);
    }
}
