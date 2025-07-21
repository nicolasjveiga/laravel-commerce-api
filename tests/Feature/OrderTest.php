<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $token = $user->createToken('UserToken')->plainTextToken;
        return ['Authorization' => "Bearer $token", 'user' => $user];
    }

    protected function setupCart($user)
    {
        $product = Product::factory()->create(['stock' => 10, 'price' => 100]);
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'unitPrice' => $product->price,
        ]);
        return $product;
    }

    public function test_user_can_create_order()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];
        $address = Address::factory()->create(['user_id' => $user->id]);
        $this->setupCart($user);

        $response = $this->postJson('/api/orders', [
            'address_id' => $address->id,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertCreated()
                 ->assertJsonFragment(['address_id' => $address->id]);
        $this->assertDatabaseHas('orders', ['address_id' => $address->id]);
    }

    public function test_user_can_create_order_with_coupon()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];
        $address = Address::factory()->create(['user_id' => $user->id]);
        $this->setupCart($user);

        $coupon = Coupon::factory()->create([
            'startDate' => now()->subDay()->format('Y-m-d'),
            'endDate' => now()->addDay()->format('Y-m-d'),
            'discountPercentage' => 10
        ]);

        $response = $this->postJson('/api/orders', [
            'address_id' => $address->id,
            'coupon_id' => $coupon->id,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertCreated()
                 ->assertJsonFragment(['coupon_id' => $coupon->id]);
    }

    public function test_user_cannot_create_order_with_empty_cart()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];
        $address = Address::factory()->create(['user_id' => $user->id]);

        Cart::factory()->create(['user_id' => $user->id]);

        $response = $this->postJson('/api/orders', [
            'address_id' => $address->id,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(400)
                 ->assertJsonFragment(['message' => 'Cart is empty']);
    }

    public function test_moderator_can_list_orders()
    {
        $user = User::factory()->create(['role' => 'MODERATOR']);
        $token = $user->createToken('UserToken')->plainTextToken;
        $address = Address::factory()->create(['user_id' => $user->id]);
        $this->setupCart($user);

        $this->postJson('/api/orders', [
            'address_id' => $address->id,
        ], [
            'Authorization' => "Bearer $token"
        ]);

        $response = $this->getJson('/api/orders', [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertOk()
                ->assertJsonStructure([['id', 'address_id', 'items']]);
    }

    public function test_user_can_cancel_order()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];
        $address = Address::factory()->create(['user_id' => $user->id]);
        $this->setupCart($user);

        $orderResponse = $this->postJson('/api/orders', [
            'address_id' => $address->id,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $orderId = $orderResponse->json('id');

        $response = $this->postJson("/api/orders/{$orderId}/cancel", [], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertNoContent();
        $this->assertDatabaseHas('orders', ['id' => $orderId, 'status' => 'CANCELED']);
    }

    public function test_moderator_can_update_order_status()
    {
        $user = User::factory()->create(['role' => 'MODERATOR']);
        $token = $user->createToken('UserToken')->plainTextToken;

        $order = Order::factory()->create(['status' => 'PENDING']);

        $response = $this->patchJson("/api/orders/{$order->id}/status", [
            'status' => 'COMPLETED'
        ], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertOk()
                 ->assertJsonFragment(['status' => 'COMPLETED']);
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'COMPLETED']);
    }

    public function test_cannot_create_order_when_product_has_insufficient_stock()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];
        $address = Address::factory()->create(['user_id' => $user->id]);

        $product = Product::factory()->create(['stock' => 1, 'price' => 100]);
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'unitPrice' => $product->price,
        ]);

        $response = $this->postJson('/api/orders', [
            'address_id' => $address->id,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(400)
                ->assertJsonFragment(['message' => "Product {$product->name} does not have enough stock"]);
    }

    public function test_stock_decreases_after_order_creation()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];
        $address = Address::factory()->create(['user_id' => $user->id]);

        $product = $this->setupCart($user);

        $this->postJson('/api/orders', [
            'address_id' => $address->id,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 8,
        ]);
    }
    public function test_stock_is_restored_on_order_cancel()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];
        $address = Address::factory()->create(['user_id' => $user->id]);
        $product = $this->setupCart($user);

        $orderResponse = $this->postJson('/api/orders', [
            'address_id' => $address->id,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $orderId = $orderResponse->json('id');

        $this->postJson("/api/orders/{$orderId}/cancel", [], [
            'Authorization' => $auth['Authorization']
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 10, 
        ]);
    }

    public function test_user_cannot_cancel_order_of_another_user() //falhando
    {
        $auth1 = $this->authenticate();
        $user1 = $auth1['user'];
        $address = Address::factory()->create(['user_id' => $user1->id]);
        $this->setupCart($user1);

        $orderResponse = $this->postJson('/api/orders', [
            'address_id' => $address->id,
        ], [
            'Authorization' => $auth1['Authorization']
        ]);

        $orderId = $orderResponse->json('id');

        $auth2 = $this->authenticate();

        $response = $this->postJson("/api/orders/{$orderId}/cancel", [], [
            'Authorization' => $auth2['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_cannot_cancel_completed_or_already_canceled_order()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'status' => 'COMPLETED'
        ]);

        $response = $this->postJson("/api/orders/{$order->id}/cancel", [], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(400)
                ->assertJsonFragment(['message' => 'Order cannot be cancelled']);
    }
}