<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{

    public function run(): void
    {
        Category::create([
            'name' => 'Eletrônicos',
            'description' => 'Eletrônicos',
        ]);

        Category::create([
            'name' => 'Moda',
            'description' => 'Roupas, calçados e acessórios para todos os estilos e gêneros.',
        ]);

        Category::create([
            'name' => 'Casa e Decoração',
            'description' => 'Móveis, utensílios domésticos, iluminação e itens decorativos.',
        ]);

        Category::create([
            'name' => 'Ferramentas',
            'description' => 'Ferramentas, equipamentos para construção, manutenção e reparo.',
        ]);

        Category::create([
            'name' => 'Alimentação',
            'description' => 'Alimentos, bebidas e suplementos alimentares.',
        ]);
    }
}
