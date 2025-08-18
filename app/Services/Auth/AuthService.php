<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepository;
use App\Exceptions\Auth\UserNotFoundException;
use App\Exceptions\Auth\InvalidCredentialsException;

class AuthService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(array $data): array
    {
        $user = $this->userRepo->create($data, 'CLIENT');

        $token = $user->createToken('UserToken')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function registerMod(array $data): array
    {
        $user = $this->userRepo->create($data, 'MODERATOR');

        $token = $user->createToken('UserToken')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function login(array $credentials): array
    {
        $user = $this->userRepo->findByEmail($credentials['email']);

        if (!$user){
            throw new UserNotFoundException();
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            throw new InvalidCredentialsException();
        }

        $token = $user->createToken('UserToken')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }
}
