<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{

    public function all()
    {
        return User::all();
    }

    public function find(User $user): User
    {
        return $user;
    }

    public function create(array $data, string $role): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $role,
        ]);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
