<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Services\Admin\AdminUserService;   

class AdminUserController extends Controller
{

    public function __construct(protected AdminUserService $adminUserService)
    {}

    public function store(StoreAdminRequest $request) // SUPER OK
    {
        return ApiResponse::success(
            new UserResource($this->adminUserService->createModerator($request->validated())),
            201);
    }
}
