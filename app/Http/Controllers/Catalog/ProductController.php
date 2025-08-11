<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Product;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;


class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $this->authorize('viewAny', Product::class);

        $products = $this->productService->listAll();
        
        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        $this->authorize('view', $product);
        
        $product = $this->productService->show($product);
        
        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);
    
        $validated = $request->validated();

        $product = $this->productService->create($validated);
        
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        
        $validated = $request->validated();

        $product = $this->productService->update($product, $validated);
        
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        
        $this->productService->delete($product);
        
        return response()->json(null, 204);
    }
}
