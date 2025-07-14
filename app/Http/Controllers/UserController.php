<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user(); //procura o user autenticado

        return response()->json([
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'role' => $user->role
        ], 200);
    }


    public function store(Request $request){
        //
    }

    public function show(string $id)
    {
        //
    }

    public function update(UpdateUserRequest $request){
        $user = Auth::user(); // user autenticado

        $dataValidated = $request->validated();

        $user->update($dataValidated);
        return response()->json([ 
            'message' => 'Usuario atualizado com sucesso!',
            'user' => $user
        ], 200);
    }

    public function destroy()
    {
        $user = Auth::user();

        $user->delete();
        return response()->json([
            'message' => 'Usuario excluido com sucesso!'
        ], 200);
    }
}
