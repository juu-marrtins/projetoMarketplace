<?php

namespace App\Http\Services\Admin;

use App\Http\Repository\Admin\AdminUserRepository;

class AdminUserService{

    public function __construct(protected AdminUserRepository $adminUserRepository)
    { }

    public function createModerator(array $dataValidated)
    {
        $dataValidated['role'] = 'MODERATOR';
        return $this->adminUserRepository->create($dataValidated);
    }
}