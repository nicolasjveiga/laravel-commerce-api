<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Coupon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create(['role' => 'ADMIN']);
        $token = $user->createToken('UserToken')->plainTextToken;

        return ['Authorization' => "Bearer $token", 'user' => $user];
    }

    public function test_admin_can_create_coupon()
    {
        $auth = $this->authenticate();

        $response = $this->postJson('/api/coupons', [
            'code' => 'PROMO10',
            'startDate' => '2025-07-15',
            'endDate' => '2025-07-31',
            'discountPercentage' => 10
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertCreated()
                 ->assertJsonFragment(['code' => 'PROMO10']);
        $this->assertDatabaseHas('coupons', ['code' => 'PROMO10']);
    }

    public function test_admin_can_list_coupons()
    {
        $auth = $this->authenticate();

        Coupon::factory()->count(2)->create();

        $response = $this->getJson('/api/coupons', [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertOk()
                 ->assertJsonCount(2);
    }

    public function test_admin_can_update_coupon()
    {
        $auth = $this->authenticate();

        $coupon = Coupon::factory()->create([
            'code' => 'PROMO30',
        ]);

        $response = $this->putJson("/api/coupons/{$coupon->id}", [
            'discountPercentage' => 25
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertOk()
                 ->assertJsonFragment(['discountPercentage' => 25]);
        $this->assertDatabaseHas('coupons', ['id' => $coupon->id, 'discountPercentage' => 25]);
    }

    public function test_admin_can_delete_coupon()
    {
        $auth = $this->authenticate();

        $coupon = Coupon::factory()->create();

        $response = $this->deleteJson("/api/coupons/{$coupon->id}", [], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertNoContent();
        $this->assertDatabaseMissing('coupons', ['id' => $coupon->id]);
    }
}