<?php

namespace App\Repositories\Catalog;

use App\Models\Catalog\Category;
use App\Exceptions\Category\CategoryWithProductsException;

class CategoryRepository
{
    public function all()
    {
        return Category::all();
    }

    public function find(Category $category)
    {
        return $category;
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category): void
    {
        if ($category->products()->exists()) {
            throw new CategoryWithProductsException();
        }
        $category->delete();
    }
}