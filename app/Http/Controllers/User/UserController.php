<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Services\User\UserService;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {}
    
    public function me()
    {
        $user = $this->userService->getAuthUser();

        return response()->json([
            'success' => true,
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'role' => $user->role
        ], 200);
    }

    public function store(StoreUserRequest $request)
    {                    
        return response()->json([
            'success' => true,
            'message' => 'Usuário criado com sucesso!',
            'data' => $this->userService->createUser($request->validated())
        ], 201);
    }

    public function update(UpdateUserRequest $request)
    {
        return response()->json([ 
            'success' => true,
            'message' => 'Usuario atualizado com sucesso!',
            'data' => $this->userService->updateUser($request->validated())
        ], 200);
    }

    public function destroy()
    {
        $this->userService->deleteUser();

        return response()->json([
            'success' => true,
            'message' => 'Usuario excluido com sucesso!'
        ], 200);
    }
}
