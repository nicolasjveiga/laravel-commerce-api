<?php

namespace App\Services\Catalog;

use App\Models\Catalog\Product;
use App\Repositories\Catalog\ProductRepository;

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

    public function verifyImage(array $data)
    {
        if(request()->hasFile('image')) {
            $imagePath = request()->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }
        return $data;
    }

    public function create(array $data): Product
    {
        $data = $this->verifyImage($data);

        return $this->productRepo->create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $data = $this->verifyImage($data);

        return $this->productRepo->update($product, $data);
    }

    public function delete(Product $product): void
    {
        $this->productRepo->delete($product);
    }
}
