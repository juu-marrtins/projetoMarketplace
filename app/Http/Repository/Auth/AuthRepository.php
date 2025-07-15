<?php

namespace App\Http\Repository\Auth;

use Illuminate\Support\Facades\Auth;

class AuthRepository{
    public function attempt(array $dataValidated)
    {
        return Auth::attempt($dataValidated);
    }

    public function getAuthUser()
    {
        return Auth::user();
    }
}