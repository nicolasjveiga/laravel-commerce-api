<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function listAll()
    {
        return $this->categoryRepo->all();
    }

    public function show(Category $category)
    {
        return $this->categoryRepo->find($category);
    }

    public function create(array $data): Category
    {
        return $this->categoryRepo->create($data);
    }

    public function update(Category $category, array $data): Category
    {
        return $this->categoryRepo->update($category, $data);
    }

    public function delete(Category $category): void
    {
        $this->categoryRepo->delete($category);
    }
}