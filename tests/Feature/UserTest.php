<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create(['role' => 'ADMIN']);
        $token = $user->createToken('UserToken')->plainTextToken;

        return ['Authorization' => "Bearer $token", 'user' => $user];
    }

    public function test_admin_can_list_users()
    {
        $auth = $this->authenticate();

        User::factory()->count(2)->create();

        $response = $this->getJson('/api/users', [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertOk()
                ->assertJsonCount(3);
    }

    public function test_admin_can_view_user()
    {
        $auth = $this->authenticate();

        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}", [
            'Authorization' => $auth['Authorization']
        ]); 

        $response->assertOk()
                ->assertJsonFragment(['name' => $user->name]);

    }
    
    public function test_admin_can_create_user()
    {
        $auth = $this->authenticate();

        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'bVZ3O@example.com',
            'password' => 'password',
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertCreated()
                ->assertJsonFragment(['name' => 'John Doe']);
    }

    public function test_admin_can_update_user()
    {
        $auth = $this->authenticate();

        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'John Doe',
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertOk()
                ->assertJsonFragment(['name' => 'John Doe']);
    }

    public function test_admin_can_delete_user()
    {
        $auth = $this->authenticate();

        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}", [], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertNoContent();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
