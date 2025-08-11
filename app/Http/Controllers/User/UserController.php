<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = $this->userService->listAll();

        return response()->json($users, 200);
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user = $this->userService->show($user);
        
        return response()->json($user, 200);
    }

    public function store(RegisterRequest $request)
    {
        $this->authorize('create', User::class);
        
        $validated = $request->validated();

        $user = $this->userService->create($validated);
        
        return response()->json($user, 201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validated();

        $user = $this->userService->update($user, $validated);
        
        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $this->userService->delete($user);

        return response()->json(null, 204);
    }
}
