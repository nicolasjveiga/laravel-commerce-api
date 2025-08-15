<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User\User;
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
    
        $response->assertOk()
                    ->assertJsonFragment(['name' => 'Test User']);
    }
    
    public function test_user_can_login(): void
    {
        User::factory()->create([
            'email' => 'test@email.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@email.com',
            'password' => 'password',
        ]);

        $response->assertOk()
                    ->assertJsonFragment(['email' => 'test@email.com']);
    }
}