<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {}
        
    public function index()
    {
        $user = Auth::user(); //procura o user autenticado

        return response()->json([
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'role' => $user->role
        ], 200);
    }


    public function store(StoreUserRequest $request){


        $this->userService->createUser($request->validated());
                        
        return response()->json(['message' => 'Usuário criado com sucesso!'], 201);
    }

    public function show(string $id)
    {
        //
    }

    public function update(UpdateUserRequest $request){
        $user = Auth::user(); // user autenticado

        $dataValidated = $request->validated();

        $user->update($dataValidated);
        return response()->json([ 
            'message' => 'Usuario atualizado com sucesso!',
            'user' => $user
        ], 200);
    }

    public function destroy()
    {
        $user = Auth::user();

        $user->delete();
        return response()->json([
            'message' => 'Usuario excluido com sucesso!'
        ], 200);
    }
}
