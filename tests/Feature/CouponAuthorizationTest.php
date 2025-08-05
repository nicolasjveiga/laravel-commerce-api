<?php

namespace Tests\Feature;

use App\Models\Coupon;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $token = $user->createToken('UserToken')->plainTextToken;

        return ['Authorization' => "Bearer $token", 'user' => $user];
    }

    protected function authenticateMod()
    {
        $user = User::factory()->create(['role' => 'MODERATOR']);
        $token = $user->createToken('UserToken')->plainTextToken;

        return ['Authorization' => "Bearer $token", 'user' => $user];
    }

    public function test_user_cannot_list_coupon()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $response = $this->getJson('/api/coupons', [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_user_cannot_create_coupon()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $response = $this->postJson('/api/coupons', [
            'code' => 'ABC123',
            'discount' => 10,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_user_cannot_update_coupon()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];
        $coupon = Coupon::factory()->create();

        $response = $this->putJson('/api/coupons/' . $coupon->id, [
            'code' => 'ABC123',
            'discount' => 10,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_user_cannot_delete_coupon()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];
        $coupon = Coupon::factory()->create();

        $response = $this->deleteJson('/api/coupons/' . $coupon->id, [], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_moderator_cannot_list_coupon()
    {
        $auth = $this->authenticateMod();
        $user = $auth['user'];

        $response = $this->getJson('/api/coupons', [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_moderator_cannot_create_coupon()
    {
        $auth = $this->authenticateMod();
        $user = $auth['user'];

        $response = $this->postJson('/api/coupons', [
            'code' => 'ABC123',
            'discount' => 10,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_moderator_cannot_update_coupon()
    {
        $auth = $this->authenticateMod();
        $user = $auth['user'];
        $coupon = Coupon::factory()->create();

        $response = $this->putJson('/api/coupons/' . $coupon->id, [
            'code' => 'ABC123',
            'discount' => 10,
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_moderator_cannot_delete_coupon()
    {
        $auth = $this->authenticateMod();
        $user = $auth['user'];
        $coupon = Coupon::factory()->create();

        $response = $this->deleteJson('/api/coupons/' . $coupon->id, [], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

}