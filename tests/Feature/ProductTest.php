<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create(['role' => 'MODERATOR']);
        $token = $user->createToken('UserToken')->plainTextToken;

        return ['Authorization' => "Bearer $token", 'user' => $user];
    }

    public function test_user_can_create_product()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $category = Category::factory()->create();

        $response = $this->postJson('/api/products', [
            'category_id' => $category->id,
            'name' => 'Product A',
            'stock' => 10,
            'price' => 100.00,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertCreated()
                 ->assertJsonFragment(['name' => 'Product A']);
    }
     
    public function test_user_can_list_products()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        Product::factory()->count(2)->create();

        $response = $this->getJson('/api/products', [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertOk()
                    ->assertJsonCount(2);
    }

    public function test_user_can_update_product()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $product = Product::factory()->create([
            'name' => 'Product B',
        ]);

        $response = $this->putJson("/api/products/{$product->id}", [
            'category_id' => $product->category_id,
            'name' => 'Product B Updated',
            'stock' => 20,
            'price' => 150.00,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertOk()
                    ->assertJsonFragment(['name' => 'Product B Updated']);
    }

    public function test_user_can_delete_product()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}", [], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertNoContent();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}