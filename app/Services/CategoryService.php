<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function createCategory(array $data)
    {
        return Category::create($data);
    }

    public function updateCategory($category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function deleteCategory($category)
    {
        $category->delete();
    }
}