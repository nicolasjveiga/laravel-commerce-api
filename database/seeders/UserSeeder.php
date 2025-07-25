<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Alice Silva',
            'email' => 'alice@email.com',
            'password' => Hash::make('senha123'),
            'role' => 'CLIENT',
        ]);

        User::create([
            'name' => 'Bob Souza',
            'email' => 'bob@email.com',
            'password' => Hash::make('senha123'),
            'role' => 'CLIENT',
        ]);
    }
}
