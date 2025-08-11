<?php

namespace App\Http\Controllers\Auth;

use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $result = $this->authService->register($validated);
        
        return response()->json($result, 201);
    }

    public function registerMod(RegisterRequest $request)
    {
        $validated = $request->validated();
        
        $result = $this->authService->registerMod($validated);
        
        return response()->json($result, 201);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        
        $result = $this->authService->login($validated);
        
        return response()->json($result, 200);
    }
}
