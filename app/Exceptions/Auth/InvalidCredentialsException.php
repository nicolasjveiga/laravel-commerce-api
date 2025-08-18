<?php

namespace App\Exceptions\Auth;

use Exception;

class InvalidCredentialsException extends Exception
{
    public function render($request){
        return response()->json([
            'message' => 'Invalid credentials provided'
        ], 401);
    }
}
