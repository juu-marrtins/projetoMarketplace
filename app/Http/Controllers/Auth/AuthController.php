<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginAuthRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Services\Auth\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {}

    public function login(LoginAuthRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return ApiResponse::fail('Acesso negado. Verifique suas credenciais', 401);
        }

        $user = Auth::user();   

        $user->access_token = $this->authService->createToken($user);

        return ApiResponse::success(
            'Token criado com sucesso',
            new AuthResource($user),
            201);
    }
}
