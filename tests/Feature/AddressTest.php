<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $token = $user->createToken('UserToken')->plainTextToken;

        return ['Authorization' => "Bearer $token", 'user' => $user];
    }

    public function test_user_can_create_address()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $response = $this->postJson('/api/addresses', [
            'user_id' => $user->id,
            'street' => 'Rua A',
            'number' => '123',
            'city' => 'Cidade X',
            'country' => 'Brasil',
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertCreated()
                    ->assertJsonFragment(['street' => 'Rua A']);
    }

    public function test_admin_can_list_addresses()
    {
        $user = User::factory()->create(['role' => 'ADMIN']);
        $token = $user->createToken('UserToken')->plainTextToken;

        Address::factory()->count(2)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/addresses', [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertOk()
                    ->assertJsonCount(2);
    }

    public function test_user_can_update_address()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $address = Address::factory()->create([
            'user_id' => $user->id,
            'street' => 'Antiga Rua',
        ]);

        $response = $this->putJson("/api/addresses/{$address->id}", [
            'street' => 'Nova Rua'
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertOk()
                    ->assertJsonFragment(['street' => 'Nova Rua']);
    }

    public function test_user_can_delete_address()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $address = Address::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/api/addresses/{$address->id}", [], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertNoContent();
        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }
}
