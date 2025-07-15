<?php

namespace App\Http\Services\Auth;

use App\Http\Repository\Auth\AuthRepository;

class AuthService{
    public function __construct(protected AuthRepository $authRepository)
    {}

    public function attempt(array $dataValidated)
    {
        return $this->authRepository->attempt($dataValidated);
    }

    public function getUserAuth(){
        return $this->authRepository->getAuthUser();
    }

    public function createToken(array $dataValidated)
    {
        if (!$this->authRepository->attempt($dataValidated)) {
            return null; 
        }

        $user = $this->authRepository->getAuthUser();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];
    }
}