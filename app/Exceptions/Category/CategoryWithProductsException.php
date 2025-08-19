<?php

namespace App\Exceptions\Category;

use Exception;

class CategoryWithProductsException extends Exception
{
    public function render($request){
        return response()->json([
            'message' => 'Cannot delete category that has products.'
        ], 404);
    }
}
