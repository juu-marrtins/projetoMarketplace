<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Services\Admin\AdminUserService;   

class AdminUserController extends Controller
{

    public function __construct(protected AdminUserService $adminUserService)
    {}

    public function store(StoreAdminRequest $request)
    {
        $this->adminUserService->createModerator($request->validated());
            
        return response()->json(['message' => 'Usuário da role MODERATOR criado com sucesso!'], 201);
    }
}
