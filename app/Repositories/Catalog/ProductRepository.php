<?php

namespace App\Repositories\Catalog;

use App\Models\Catalog\Product;

class ProductRepository
{
    public function all()
    {
        return Product::all();
    }

    public function find(Product $product)
    {
        return $product;
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
}
