<?php

namespace App\Services\User;

use App\Models\User\User;
use App\Repositories\User\UserRepository;

class UserService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function listAll()
    {
        return $this->userRepo->all();
    }

    public function show(User $user)
    {
        return $this->userRepo->find($user);
    }

    public function create(array $data): User
    {
        return $this->userRepo->create($data, 'CLIENT');
    }

    public function update(User $user, array $data): User
    {
        return $this->userRepo->update($user, $data);
    }

    public function delete(User $user): void
    {
        $this->userRepo->delete($user);
    }
}
