<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Catalog\Product;
use App\Models\Discount\Discount;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiscountAuthorizationTest extends TestCase
{

    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create(['role' => 'CLIENT']);
        $token = $user->createToken('UserToken')->plainTextToken;

        return ['Authorization' => "Bearer $token", 'user' => $user];
    }

    protected function authenticateMod()
    {
        $user = User::factory()->create(['role' => 'MODERATOR']);
        $token = $user->createToken('UserToken')->plainTextToken;

        return ['Authorization' => "Bearer $token", 'user' => $user];
    }

    public function test_user_cannot_list_discounts()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $response = $this->getJson('/api/discounts', [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_user_cannot_show_discount()
    {
        $auth = $this->authenticate();
        $discount = Discount::factory()->create();

        $response = $this->getJson("/api/discounts/{$discount->id}", [
            'Authorization' => $auth['Authorization']
        ]);
        
        $response->assertStatus(403);
    }

    public function test_user_cannot_create_discount()
    {
        $auth = $this->authenticate();

        $product = Product::factory()->create();

        $response = $this->postJson('/api/discounts', [
            'product_id' => $product->id,
            'description' => 'Promoção especial',
            'startDate' => '2025-07-15',
            'endDate' => '2025-07-31',
            'discountPercentage' => 15
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_user_cannot_update_discount()
    {
        $auth = $this->authenticate();
        $discount = Discount::factory()->create();

        $response = $this->putJson('/api/discounts/' . $discount->id, [
            'description' => 'Promoção especial',
            'startDate' => '2025-07-15',
            'endDate' => '2025-07-31',
            'discountPercentage' => 15
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_user_cannot_delete_discount()
    {
        $auth = $this->authenticate();
        $discount = Discount::factory()->create();

        $response = $this->deleteJson("/api/discounts/{$discount->id}", [],[
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_moderator_cannot_list_discounts()
    {
        $auth = $this->authenticateMod();
        $user = $auth['user'];

        $response = $this->getJson('/api/discounts', [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_moderator_cannot_show_discount()
    {
        $auth = $this->authenticateMod();
        $discount = Discount::factory()->create();

        $response = $this->getJson("/api/discounts/{$discount->id}", [
            'Authorization' => $auth['Authorization']
        ]);
        
        $response->assertStatus(403);
    }

    public function test_moderator_cannot_create_discount()
    {
        $auth = $this->authenticateMod();

        $product = Product::factory()->create();

        $response = $this->postJson('/api/discounts', [
            'product_id' => $product->id,
            'description' => 'Promoção especial',
            'startDate' => '2025-07-15',
            'endDate' => '2025-07-31',
            'discountPercentage' => 15
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_moderator_cannot_update_discount()
    {
        $auth = $this->authenticateMod();
        $discount = Discount::factory()->create();

        $response = $this->putJson('/api/discounts/' . $discount->id, [
            'description' => 'Promoção especial',
            'startDate' => '2025-07-15',
            'endDate' => '2025-07-31',
            'discountPercentage' => 15
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_moderator_cannot_delete_discount()
    {
        $auth = $this->authenticateMod();
        $discount = Discount::factory()->create();

        $response = $this->deleteJson("/api/discounts/{$discount->id}", [],[
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

}
