<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

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
        return response()->json($this->userService->listAll());
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        return response()->json($this->userService->show($user));
    }

    public function store(RegisterRequest $request)
    {
        $this->authorize('create', User::class);
        $user = $this->userService->create($request->validated());
        return response()->json($user, 201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user = $this->userService->update($user, $request->validated());
        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $this->userService->delete($user);
        return response()->json(null, 204);
    }
}
