<?php

namespace App\Http\Services\User;

use App\Http\Repository\User\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{

    public function __construct(protected UserRepository $userRepository)
    {}

    public function getAuthUser()
    {
        return Auth::user();
    }

    public function createUser(array $dataValidated)
    {
        return User::create($dataValidated);
    }

    public function updateUser(array $dataValidated)
    {
        $user = $this->getAuthUser();

        $user->update($dataValidated);

        return $user;
    }

    public function deleteUser()
    {
        $user = $this->getAuthUser();
        $user->delete();

        return $user;
    }
}