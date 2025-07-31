<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;


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
        
        return response()->json($products, 200);
    }

    public function show(Product $product)
    {
        $this->authorize('view', $product);
        
        $product = $this->productService->show($product);
        
        return response()->json($product, 200);
    }

    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);
    
        $validated = $request->validated();

        $product = $this->productService->create($validated);
        
        return response()->json($product, 201);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        
        $validated = $request->validated();

        $product = $this->productService->update($product, $validated);
        
        return response()->json($product, 200);
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        
        $this->productService->delete($product);
        
        return response()->json(null, 204);
    }
}
