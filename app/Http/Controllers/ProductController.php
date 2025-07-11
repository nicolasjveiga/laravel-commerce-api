<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = Product::with('category')->get();
        
        return response()->json($products);
    }

    public function show(Product $product)
    {
        $product->load('category');
        
        return response()->json($product);
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $product = $this->productService->createProduct($validated);
        
        return response()->json($product, 201);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $product = $this->productService->updateProduct($product, $validated);
        
        return response()->json($product);
    }

     public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);
        
        return response()->json(null, 204);
    }
}
