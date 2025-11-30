<?php

namespace App\Http\Service;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function addUser(Request $request):User{
        return User::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'password'=>Hash::make($request['password']),
            'role'=>$request['role'],
        ]);
    }
    public function getUserByEmail($email):User{
        return User::where([
            'email'=>$email,
        ])->first();
    }
}
