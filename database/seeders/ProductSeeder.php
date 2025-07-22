<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {

        $electronics = Category::where('name', 'Eletrônicos')->first();
        Product::create([
            'name' => 'Smartphone Galaxy Z',
            'price' => 3499.99,
            'stock' => 30,
            'category_id' => $electronics->id,
        ]);
        Product::create([
            'name' => 'Notebook Dell Inspiron 15',
            'price' => 4599.00,
            'stock' => 15,
            'category_id' => $electronics->id,
        ]);
        Product::create([
            'name' => 'Fone Bluetooth JBL Tune 510BT',
            'price' => 299.90,
            'stock' => 100,
            'category_id' => $electronics->id,
        ]);
        Product::create([
            'name' => 'Smartwatch Amazfit GTS 4',
            'price' => 999.00,
            'stock' => 25,
            'category_id' => $electronics->id,
        ]);
        Product::create([
            'name' => 'TV 50" 4K Samsung Crystal UHD',
            'price' => 2799.99,
            'stock' => 12,
            'category_id' => $electronics->id,
        ]);

        $fashion = Category::where('name', 'Moda')->first();
        Product::create([
            'name' => 'Camiseta Básica Branca',
            'price' => 39.90,
            'stock' => 200,
            'category_id' => $fashion->id,
        ]);
        Product::create([
            'name' => 'Tênis Esportivo Nike Air Max',
            'price' => 499.00,
            'stock' => 40,
            'category_id' => $fashion->id,
        ]);
        Product::create([
            'name' => 'Jaqueta Jeans Oversized',
            'price' => 229.90,
            'stock' => 60,
            'category_id' => $fashion->id,
        ]);
        Product::create([
            'name' => 'Boné Aba Curva New Era',
            'price' => 89.90,
            'stock' => 80,
            'category_id' => $fashion->id,
        ]);

        $home = Category::where('name', 'Casa e Decoração')->first();
        Product::create([
            'name' => 'Luminária de Mesa LED',
            'price' => 129.90,
            'stock' => 45,
            'category_id' => $home->id,
        ]);
        Product::create([
            'name' => 'Jogo de Panelas Antiaderente 5 peças',
            'price' => 279.99,
            'stock' => 20,
            'category_id' => $home->id,
        ]);
        Product::create([
            'name' => 'Almofada Decorativa Geométrica',
            'price' => 49.90,
            'stock' => 70,
            'category_id' => $home->id,
        ]);

        $tools = Category::where('name', 'Ferramentas')->first();
        Product::create([
            'name' => 'Furadeira de Impacto 650W Bosch',
            'price' => 299.00,
            'stock' => 18,
            'category_id' => $tools->id,
        ]);
        Product::create([
            'name' => 'Jogo de Chaves Allen 9 peças',
            'price' => 49.90,
            'stock' => 50,
            'category_id' => $tools->id,
        ]);

        $food = Category::where('name', 'Alimentação')->first();
        Product::create([
            'name' => 'Kit Whey Protein 1Kg + Coqueteleira',
            'price' => 179.90,
            'stock' => 35,
            'category_id' => $food->id,
        ]);
    }
}
