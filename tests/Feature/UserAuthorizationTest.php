<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAuthorizationTest extends TestCase
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

    public function test_user_cannot_list_users()
    {
        $auth = $this->authenticate();

        User::factory()->count(2)->create();

        $response = $this->getJson('/api/users', [
            'Authorization' => $auth['Authorization']
        ]);
        
        $response->assertStatus(403);
    }
 
    public function test_user_cannot_show_user()
    {
        $auth = $this->authenticate();
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}", [
            'Authorization' => $auth['Authorization']
        ]); 

        $response->assertStatus(403);
    }

    public function test_user_cannot_create_user() //pode mas só na rota de Register
    {
        $auth = $this->authenticate();

        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'bVZ3O@example.com',
            'password' => 'password',
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_user_cannot_update_user()
    {
        $auth = $this->authenticate();
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'John Doe',
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }

    public function test_user_cannot_delete_user()
    {
        $auth = $this->authenticate();
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}", [], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertStatus(403);
    }
}
