<?php

namespace App\Http\Controllers\User;

use App\Models\User\User;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;

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

        return UserResource::collection($users);
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user = $this->userService->show($user);
        
        return new UserResource($user);
    }

    public function store(RegisterRequest $request)
    {
        $this->authorize('create', User::class);
        
        $validated = $request->validated();

        $user = $this->userService->create($validated);
        
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validated();

        $user = $this->userService->update($user, $validated);
        
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $this->userService->delete($user);

        return response()->json(null, 204);
    }
}
