<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

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
        $this->authorize('registerMod');

        $validated = $request->validated();
        
        $result = $this->authService->registerMod($validated);
        
        return response()->json($result, 201);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        
        $result = $this->authService->login($validated);
        
        return response()->json($result);
    }
}
