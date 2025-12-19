<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Service\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected UserService $userService;
    public function __construct(UserService $userService){
        $this->userService=$userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user=$this->userService->getUserById($user);
        return response()->json(['user'=>new UserResource($user)],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $userUpdated=$this->userService->updateUser($request->toArray(),$user);
        return response()->json(['user'=>new UserResource($userUpdated)],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $userDeleted=$this->userService->deleteUser($user);
        return response()->json(['message'=>"User deleted successfully"],200);
    }
    public function getUsersForRole($role){
        $validator=Validator::make(['role'=>$role],[
            'role'=> 'required|in:admin,company,student,alumni',

        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $users=$this->userService->getUsersByRole($role,10);
        return response()->json(['users'=>UserResource::collection($users),"message"=>"Users for role $role founded successfully "],200);
    }
    public function me(Request $request){
        $user=$this->userService->getUserById($request->user()->id);
        return response()->json(['user'=>new UserResource($user)],200);
    }

}
