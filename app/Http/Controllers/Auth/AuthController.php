<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginAuthRequest;
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
                'success' => false,
                'message' => 'Acesso negado. Verifique suas credenciais',
                'data' => []
            ], 401);
        }
        return response()->json([
            'success' => true,
            'message' => 'Token criado com sucesso',
            'data' => $createTokenOrFail
        ], 200);
    }
}
