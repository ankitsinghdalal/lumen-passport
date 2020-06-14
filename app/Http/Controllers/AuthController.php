<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends RestController
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        return $this->sendResponse([]);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $request->merge([
            'password' => Hash::make($request->input('password'))
        ]);
        
        $user =  User::create($request->all());
      
        return $this->sendResponse([
            'token' => $user->createToken('MyApp')->accessToken,
        ], trans('messages.USER_CREATE_SUCCESS'));
    }

    public function logout(Request $request)
    {
        //Here I want to get the current user
        return $this->sendResponse();
    }


}
