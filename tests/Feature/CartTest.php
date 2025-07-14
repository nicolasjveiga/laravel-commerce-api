<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $token = $user->createToken('UserToken')->plainTextToken;

        return ['Authorization' => "Bearer $token", 'user' => $user];
    }

    public function test_user_can_add_product_to_cart()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $product = Product::factory()->create(['stock' => 5]);

        $response = $this->postJson('/api/cart', [
            'product_id' => $product->id,
            'quantity' => 2,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertCreated()
                 ->assertJsonFragment(['product_id' => $product->id, 'quantity' => 2]);
    }

    public function test_user_can_view_cart()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $response = $this->getJson('/api/cart', [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertOk()
                 ->assertJsonIsArray();
    }

    public function test_user_can_update_cart_item()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $product = Product::factory()->create(['stock' => 10, 'price' => 10.00]);

        $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);

        $cartItem = $cart->items()->create(['product_id' => $product->id, 'quantity' => 1, 'unitPrice' => $product->price]);

        $response = $this->putJson("/api/cart/{$cartItem->id}", [
            'quantity' => 3,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertOk()
                ->assertJsonFragment(['id' => $cartItem->id, 'quantity' => 3]);
    }

    public function test_user_can_remove_item_from_cart()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $product = Product::factory()->create(['stock' => 10, 'price' => 10.00]);

        $cart = $user->cart()->firstOrCreate(['user_id' => $user->id]);

        $cartItem = $cart->items()->create(['product_id' => $product->id, 'quantity' => 1, 'unitPrice' => $product->price]);

        $response = $this->deleteJson("/api/cart/{$cartItem->id}", [], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertNoContent();
    }
}