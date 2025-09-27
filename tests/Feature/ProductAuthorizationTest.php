<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Catalog\Product;
use App\Models\Catalog\Category;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticateAs($role)
    {
        $user = User::factory()->create(['role' => $role]);
        $token = $user->createToken('UserToken')->plainTextToken;

        return "Bearer $token";
    }

    public function test_client_cannot_create_product(){
        
        $user = User::factory()->create(['role' => 'CLIENT']);
        $token = $user->createToken('UserToken')->plainTextToken;

        $category = Category::factory()->create();

        $response = $this->postJson('/api/products', [
            'category_id' => $category->id,
            'name' => 'Product A',
            'stock' => 10,
            'price' => 100.00,
        ], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertForbidden();
    }
    
    public function test_client_cannot_update_product(){
        
        $user = User::factory()->create(['role' => 'CLIENT']);
        $token = $user->createToken('UserToken')->plainTextToken;

        $product = Product::factory()->create();
        
        $response = $this->postJson("/api/products/{$product->id}", [
            'category_id' => $product->category_id,
            'name' => 'Product B Updated',
            'stock' => 20,
            'price' => 150.00,
        ], [
            'Authorization' => "Bearer $token"
        ]);
        $response->assertForbidden();
    }

    public function test_client_cannot_delete_product(){
        
        $user = User::factory()->create(['role' => 'CLIENT']);
        $token = $user->createToken('UserToken')->plainTextToken;

        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}", [], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertForbidden();
    }

       public function test_admin_cannot_create_product(){
        
        $user = User::factory()->create(['role' => 'ADMIN']);
        $token = $user->createToken('UserToken')->plainTextToken;

        $category = Category::factory()->create();

        $response = $this->postJson('/api/products', [
            'category_id' => $category->id,
            'name' => 'Product A',
            'stock' => 10,
            'price' => 100.00,
        ], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertForbidden();
    }
    
    public function test_admin_cannot_update_product(){
        
        $user = User::factory()->create(['role' => 'ADMIN']);
        $token = $user->createToken('UserToken')->plainTextToken;

        $product = Product::factory()->create();
        
        $response = $this->postJson("/api/products/{$product->id}", [
            'category_id' => $product->category_id,
            'name' => 'Product B Updated',
            'stock' => 20,
            'price' => 150.00,
        ], [
            'Authorization' => "Bearer $token"
        ]);
        $response->assertForbidden();
    }

    public function test_admin_cannot_delete_product(){
        
        $user = User::factory()->create(['role' => 'ADMIN']);
        $token = $user->createToken('UserToken')->plainTextToken;

        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}", [], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertForbidden();
    }

}
