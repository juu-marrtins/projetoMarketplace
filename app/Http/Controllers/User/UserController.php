<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Services\User\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {}
    
    public function me()
    {
        return response()->json([
            'success' => true,
            'data' => new UserResource(Auth::user())
        ], 200);
    }

    public function store(StoreUserRequest $request)
    {           
        return response()->json([
            'success' => true,
            'message' => 'Usuário criado com sucesso!',
            'data' => new UserResource($this->userService->createUser($request->validated()))
        ], 201);
    }

    public function update(UpdateUserRequest $request)
    {
        return response()->json([ 
            'success' => true,
            'message' => 'Usuario atualizado com sucesso!',
            'data' => new UserResource($this->userService->updateUser(
                Auth::user(), 
                $request->validated()))
        ], 200);
    }

    public function destroy()
    {
        $this->userService->deleteUser(Auth::user());
        return response()->json([
            'success' => true,
            'message' => 'Usuario excluido com sucesso!'
        ], 200);
    }
}
