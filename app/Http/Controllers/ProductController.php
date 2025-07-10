<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return response()->json(['message' => 'List of products']);
    }

    public function show($id)
    {
        return response()->json(['message' => "Product details for ID: $id"]);
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $product = $this->productService->createProduct($validated);
        
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => "Product ID: $id updated successfully"]);
    }

    public function destroy($id)
    {
        return response()->json(['message' => "Product ID: $id deleted successfully"]);
    }
}
