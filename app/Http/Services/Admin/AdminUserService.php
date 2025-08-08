<?php

namespace App\Http\Services\Admin;

use App\Http\Repository\Admin\AdminUserRepository;
use App\Models\User;

class AdminUserService{

    public function __construct(protected AdminUserRepository $adminUserRepository)
    { }

    public function createModerator(array $dataValidated) : User
    {
        $dataValidated['role'] = 'MODERATOR';
        return $this->adminUserRepository->create($dataValidated);
    }
}