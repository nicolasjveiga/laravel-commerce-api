<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function createUser(array $data): User
    {
        return $this->userModel->create($data);
    }

    public function updateUser(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }
}