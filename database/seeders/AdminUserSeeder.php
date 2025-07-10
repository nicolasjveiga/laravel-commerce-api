<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@email.com',
            'password' => Hash::make('senha123'),
            'role' => 'ADMIN',
        ]);

        User::create([
            'name' => 'Moderador',
            'email' => 'mod@email.com',
            'password' => Hash::make('senha123'),
            'role' => 'MODERATOR',
        ]);
    }
}
