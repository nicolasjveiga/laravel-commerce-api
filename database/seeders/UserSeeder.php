<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'email' => 'user2@email.com',
            'password' => Hash::make('senha123'),
            'role' => 'CLIENT',
        ]);
    }
}
