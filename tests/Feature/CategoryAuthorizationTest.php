<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticateAs($role)
    {
        $user = User::factory()->create(['role' => $role]);
        $token = $user->createToken('UserToken')->plainTextToken;

        return "Bearer $token";
    }

    public function test_client_cannot_create_category(){
        
        $user = User::factory()->create(['role' => 'CLIENT']);
        $token = $user->createToken('UserToken')->plainTextToken;

        $response = $this->postJson('/api/categories', [
            'name' => 'Category A',
            'description' => 'Description for Category A',
        ], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertForbidden();
    }
    
    public function test_client_cannot_update_category(){
        
        $user = User::factory()->create(['role' => 'CLIENT']);
        $token = $user->createToken('UserToken')->plainTextToken;

        $category = Category::factory()->create();

        $response = $this->putJson("/api/categories/{$category->id}", [
            'name' => 'Category B Updated',
            'description' => 'Updated description for Category B',
        ], [
            'Authorization' => "Bearer $token"
        ]);
        $response->assertForbidden();
    }

    public function test_client_cannot_delete_category(){
        
        $user = User::factory()->create(['role' => 'CLIENT']);
        $token = $user->createToken('UserToken')->plainTextToken;

        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$category->id}", [], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertForbidden();
    }

    public function test_moderator_cannot_create_category(){
        
        $user = User::factory()->create(['role' => 'MODERATOR']);
        $token = $user->createToken('UserToken')->plainTextToken;

        $response = $this->postJson('/api/categories', [
            'name' => 'Category A',
            'description' => 'Description for Category A',
        ], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertForbidden();
    }
    
    public function test_moderator_cannot_update_category(){
        
        $user = User::factory()->create(['role' => 'MODERATOR']);
        $token = $user->createToken('UserToken')->plainTextToken;

        $category = Category::factory()->create();

        $response = $this->putJson("/api/categories/{$category->id}", [
            'name' => 'Category B Updated',
            'description' => 'Updated description for Category B',
        ], [
            'Authorization' => "Bearer $token"
        ]);
        $response->assertForbidden();
    }

    public function test_moderator_cannot_delete_category(){
        
        $user = User::factory()->create(['role' => 'MODERATOR']);
        $token = $user->createToken('UserToken')->plainTextToken;

        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$category->id}", [], [
            'Authorization' => "Bearer $token"
        ]);

        $response->assertForbidden();
    }

}
