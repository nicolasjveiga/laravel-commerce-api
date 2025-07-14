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

}