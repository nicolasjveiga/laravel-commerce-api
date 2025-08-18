<?php

namespace App\Exceptions\Auth;

use Exception;

class UserNotFoundException extends Exception
{
    public function render($request){
        return response()->json([
            'message' => 'User not found'
        ], 404);
    }
}
