<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Services\User\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {}
    
    public function me()
    {
        $user = Auth::user();

        //$this->authorize('view', $user);

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
        $user = Auth::user();

        //$this->authorize('update', $user);

        $data = $this->userService->updateUser($request->validated());

        if(!$data)
        {
            return response()->json([
                'success' => false,
                'message' => 'Nao possue permissao para alterar outro perfil.',
                'data' => []
            ], 403);
        }

        return response()->json([ 
            'success' => true,
            'message' => 'Usuario atualizado com sucesso!',
            'data' => $data
        ], 200);
    }

    public function destroy()
    {
        $user = Auth::user();
        //$this->authorize('delete', $user);

        $this->userService->deleteUser($user);

        return response()->json([
            'success' => true,
            'message' => 'Usuario excluido com sucesso!'
        ], 200);
    }
}
