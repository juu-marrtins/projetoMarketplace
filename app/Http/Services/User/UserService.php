<?php

namespace App\Http\Services\User;

use App\Http\Repository\User\UserRepository;
use App\Models\User;
class UserService
{

    public function __construct(protected UserRepository $userRepository)
    {}

    public function createUser(array $dataValidated)
    {
        $dataValidated['role'] = 'CLIENT';
        return User::create($dataValidated);
    }

    public function updateUser(User $user, array $dataValidated)
    {
        $user->update($dataValidated);

        return $user;
    }

    public function deleteUser(User $authUser)
    {
        $authUser->delete();

        return $authUser;
    }
}