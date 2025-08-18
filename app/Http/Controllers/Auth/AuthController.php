<?php

namespace App\Http\Controllers\Auth;

use App\Services\Auth\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\AuthResource;

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
        
        return new AuthResource($result);
    }

    public function registerMod(RegisterRequest $request)
    {
        $validated = $request->validated();
        
        $result = $this->authService->registerMod($validated);
        
        return new AuthResource($result);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        
        $result = $this->authService->login($validated);
        
        return new AuthResource($result);
    }
}
