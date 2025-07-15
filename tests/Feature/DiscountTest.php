<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Discount;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiscountTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create(['role' => 'ADMIN']);
        $token = $user->createToken('UserToken')->plainTextToken;

        return ['Authorization' => "Bearer $token", 'user' => $user];
    }

    public function test_admin_can_create_discount()
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

        $response->assertCreated()
                 ->assertJsonFragment(['description' => 'Promoção especial']);
        $this->assertDatabaseHas('discounts', ['description' => 'Promoção especial']);
    }

    public function test_admin_can_list_discounts()
    {
        $auth = $this->authenticate();
        Discount::factory()->count(2)->create();

        $response = $this->getJson('/api/discounts', [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertOk()
                 ->assertJsonCount(2);
    }

    public function test_admin_can_update_discount()
    {
        $auth = $this->authenticate();
        $discount = Discount::factory()->create([
            'description' => 'Desconto antigo',
        ]);

        $response = $this->putJson("/api/discounts/{$discount->id}", [
            'description' => 'Desconto atualizado'
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertOk()
                 ->assertJsonFragment(['description' => 'Desconto atualizado']);
        $this->assertDatabaseHas('discounts', ['id' => $discount->id, 'description' => 'Desconto atualizado']);
    }

    public function test_admin_can_delete_discount()
    {
        $auth = $this->authenticate();
        $discount = Discount::factory()->create();

        $response = $this->deleteJson("/api/discounts/{$discount->id}", [], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertNoContent();
        $this->assertDatabaseMissing('discounts', ['id' => $discount->id]);
    }
}