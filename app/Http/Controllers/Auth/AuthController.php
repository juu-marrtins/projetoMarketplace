<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Requests\Auth\RegisterAuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

        public function login(LoginAuthRequest $request)
        {
            $dataValidated = $request->validated();

            if(Auth::attempt($dataValidated)){ //atentica
                $user = Auth::user(); // pega o usuario autenticado
                $token = $user->createToken('auth_token')->plainTextToken; //cria para o usuario que pegamos
                return response()->json([
                    'message' => 'Token criado com sucesso',
                    'user' => $user,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ], 201);
            }
            return response()->json(['message' => 'Credenciais invalidas.'], 400);
        }

        public function register(RegisterAuthRequest $request)
        {
            $dataValidated = $request->validated();

            $user = User::create($dataValidated);
            
            return response()->json(['message' => 'Usuário criado com sucesso!'], 201);
        }
}
