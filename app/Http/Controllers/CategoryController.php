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
        return response()->json($this->categoryService->listAll());
    }

    public function show(Category $category)
    {
        return response()->json($this->categoryService->show($category));
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('create', Category::class);
        $category = $this->categoryService->create($request->validated());
        return response()->json($category, 201);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);
        $category = $this->categoryService->update($category, $request->validated());
        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $this->categoryService->delete($category);
        return response()->json(null, 204);
    }
}
