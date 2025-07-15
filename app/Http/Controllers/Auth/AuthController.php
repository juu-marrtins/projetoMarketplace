<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Requests\Auth\RegisterAuthRequest;
use App\Http\Services\Auth\AuthService;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {}
        public function login(LoginAuthRequest $request)
        {
            $createTokenOrFail = $this->authService->createToken($request->validated());
            
            if(!$createTokenOrFail)
            {
                return response()->json([
                    'message' => 'Credenciais Invalidas.'
                ], 400);
            }
            return response()->json([
                'message' => 'Token criado com sucesso',
                $createTokenOrFail
            ], 201);
        }

        public function register(RegisterAuthRequest $request)
        {
            $dataValidated = $request->validated();

            $user = User::create($dataValidated);
            
            return response()->json(['message' => 'Usuário criado com sucesso!'], 201);
        }
}
