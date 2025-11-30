<?php

namespace App\Http\Service;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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
    public function updateUser(array $request,User $user):User{
        $user->update($request);
        return $user;
    }
    public function deleteUser(User $user):User{
        $user->delete();
        return $user;
    }
    public function getUserById($id):User{
        return User::where('id',$id)->first();
    }
    public function getUsersByRole($role,int $perPage):LengthAwarePaginator{
        return User::where('role',$role)->paginate($perPage);
    }
}
