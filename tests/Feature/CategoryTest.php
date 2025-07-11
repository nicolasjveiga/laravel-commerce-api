<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create(['role' => 'ADMIN']);
        $token = $user->createToken('UserToken')->plainTextToken;

        return ['Authorization' => "Bearer $token", 'user' => $user];
    }

    public function test_user_can_create_category()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $response = $this->postJson('/api/categories', [
            'name' => 'Category A',
            'description' => 'Description for Category A',
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertCreated()
                    ->assertJsonFragment(['name' => 'Category A']);
    }

    public function test_user_can_list_category()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        Category::factory()->count(2)->create();

        $response = $this->getJson('/api/categories', [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertOk()
                    ->assertJsonCount(2);
    }

    public function test_user_can_update_category()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $category = Category::factory()->create([
            'name' => 'Category B',
        ]);

        $response = $this->putJson("/api/categories/{$category->id}", [
            'name' => 'Category B Updated',
        ], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertOk()
                    ->assertJsonFragment(['name' => 'Category B Updated']);
    }

     public function test_user_can_delete_category()
    {
        $auth = $this->authenticate();
        $user = $auth['user'];

        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$category->id}", [], [
            'Authorization' => $auth['Authorization']
        ]);

        $response->assertNoContent();
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}