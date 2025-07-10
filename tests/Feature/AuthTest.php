<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'password',
        ]);
    
        $response->assertCreated()
                    ->assertJsonStructure(['user', 'token']);
    }
    
    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@email.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@email.com',
            'password' => 'password',
        ]);

        $response->assertOk()
                    ->assertJsonStructure(['user', 'token']);
    }
}