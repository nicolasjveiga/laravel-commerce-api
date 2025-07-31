<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $this->authorize('viewAny', Category::class);

        $categories = $this->categoryService->listAll(); 
        
        return response()->json($categories, 200);
    }

    public function show(Category $category)
    {
        $this->authorize('view', $category);
        
        $category = $this->categoryService->show($category);
        
        return response()->json($category, 200);
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('create', Category::class);
        
        $validated = $request->validated();

        $category = $this->categoryService->create($validated);
        
        return response()->json($category, 201);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        $validated = $request->validated();

        $category = $this->categoryService->update($category, $validated);
        
        return response()->json($category, 200);
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $this->categoryService->delete($category);
        
        return response()->json(null, 204);
    }
}
