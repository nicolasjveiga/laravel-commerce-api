<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\User;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Address::create([
                'user_id' => $user->id,
                'street' => 'Rua Principal',
                'number' => '123',
                'city' => 'São Paulo',
                'country' => 'Brasil',
            ]);
        }
    }
}
