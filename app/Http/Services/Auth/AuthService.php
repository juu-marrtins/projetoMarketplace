<?php

namespace App\Http\Services\Auth;

use App\Models\User;

class AuthService{
    public function createToken(User $user)
    {
        return $user->createToken('auth_token')->plainTextToken;
    }
}