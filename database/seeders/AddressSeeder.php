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

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please seed users first.');
            return;
        }

        $addresses = [
            ['city' => 'São Paulo', 'state' => 'SP', 'latitude' => -23.5505, 'longitude' => -46.6333],
            ['city' => 'Rio de Janeiro', 'state' => 'RJ', 'latitude' => -22.9068, 'longitude' => -43.1729],
            ['city' => 'Belo Horizonte', 'state' => 'MG', 'latitude' => -19.9167, 'longitude' => -43.9345],
            ['city' => 'Campinas', 'state' => 'SP', 'latitude' => -22.9099, 'longitude' => -47.0626],
            ['city' => 'Curitiba', 'state' => 'PR', 'latitude' => -25.4284, 'longitude' => -49.2733],
            ['city' => 'Porto Alegre', 'state' => 'RS', 'latitude' => -30.0346, 'longitude' => -51.2177],
            ['city' => 'Florianópolis', 'state' => 'SC', 'latitude' => -27.5954, 'longitude' => -48.5480],
            ['city' => 'Santos', 'state' => 'SP', 'latitude' => -23.9608, 'longitude' => -46.3336],
            ['city' => 'Vitória', 'state' => 'ES', 'latitude' => -20.3155, 'longitude' => -40.3128],
            ['city' => 'Londrina', 'state' => 'PR', 'latitude' => -23.3045, 'longitude' => -51.1696],
            ['city' => 'Joinville', 'state' => 'SC', 'latitude' => -26.3044, 'longitude' => -48.8487],
            ['city' => 'Pelotas', 'state' => 'RS', 'latitude' => -31.7649, 'longitude' => -52.3371],
            ['city' => 'Niterói', 'state' => 'RJ', 'latitude' => -22.8832, 'longitude' => -43.1034],
            ['city' => 'Uberlândia', 'state' => 'MG', 'latitude' => -18.9128, 'longitude' => -48.2755],
            ['city' => 'São José dos Campos', 'state' => 'SP', 'latitude' => -23.1896, 'longitude' => -45.8841],
            ['city' => 'Ribeirão Preto', 'state' => 'SP', 'latitude' => -21.1704, 'longitude' => -47.8103],
            ['city' => 'Caxias do Sul', 'state' => 'RS', 'latitude' => -29.1678, 'longitude' => -51.1794],
            ['city' => 'Maringá', 'state' => 'PR', 'latitude' => -23.4206, 'longitude' => -51.9333],
            ['city' => 'Sorocaba', 'state' => 'SP', 'latitude' => -23.5015, 'longitude' => -47.4526],
            ['city' => 'São Vicente', 'state' => 'SP', 'latitude' => -23.9633, 'longitude' => -46.3919],
        ];

        foreach ($addresses as $data) {
            Address::create([
                'user_id' => $users->random()->id,
                'street' => fake()->streetName(),
                'number' => fake()->numberBetween(1, 9999),
                'city' => $data['city'],
                'country' => 'Brasil',
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ]);
        }
    }
}
