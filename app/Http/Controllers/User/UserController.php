<?php

namespace App\Http\Controllers\User;

use App\Helpers\ApiResponse;
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
        return ApiResponse::success(
            'Dados do usuário autênticado.',
            new UserResource(Auth::user()),
            200
        );
    }

    public function store(StoreUserRequest $request)
    {           
        return ApiResponse::success(
            'Usuário criado com sucesso.', 
            new UserResource($this->userService->createUser($request->validated())),
            201
        );
    }

    public function update(UpdateUserRequest $request)
    {
        return ApiResponse::success(
            'Usuário atualizado com sucesso!',
            new UserResource($this->userService->updateUser(Auth::user(), $request->validated())),
            200
        );
    }

    public function destroy()
    {
        $this->userService->deleteUser(Auth::user());

        return response()->noContent();
    }
}
