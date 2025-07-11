<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Services\CategoryService;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = Category::with('products')->get();

        return response()->json($categories);
    }

    public function show(Category $category)
    {
        $category->load('products'); 

        return response()->json($category);
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $category = $this->categoryService->createCategory($validated);

        return response()->json($category, 201);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        $category = $this->categoryService->updateCategory($category, $validated);

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $this->categoryService->deleteCategory($category);

        return response()->json(null, 204);
    }
}
