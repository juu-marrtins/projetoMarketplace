<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Services\Auth\AuthService;

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
}
