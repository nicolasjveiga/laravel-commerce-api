<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function createUser(array $data): User
    {
        return $this->userRepo->create($data);
    }

    public function updateUser(User $user, array $data): User
    {
        return $this->userRepo->update($user, $data);
    }

    public function deleteUser(User $user): void
    {
        $this->userRepo->delete($user);
    }
}
