<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function listAll()
    {
        return $this->productRepo->all();
    }

    public function show(Product $product)
    {
        return $this->productRepo->find($product);
    }

    public function create(array $data): Product
    {
        return $this->productRepo->create($data);
    }

    public function update(Product $product, array $data): Product
    {
        return $this->productRepo->update($product, $data);
    }

    public function delete(Product $product): void
    {
        $this->productRepo->delete($product);
    }
}
