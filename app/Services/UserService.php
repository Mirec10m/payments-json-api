<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function createUser(UserDTO $userDTO): UserResource
    {
        $user = User::create([
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'password' => bcrypt($userDTO->password)
        ]);

        return new UserResource($user);
    }

    public function authenticateUser(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }
}
