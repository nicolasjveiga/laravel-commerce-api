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
            'name' => 'User Client',
            'email' => 'user@email.com',
            'password' => Hash::make('senha123'),
            'role' => 'CLIENT',
        ]);

        User::create([
            'name' => 'User Client 2',
            'email' => 'user@email.com',
            'password' => Hash::make('senha123'),
            'role' => 'CLIENT',
        ]);
    }
}
