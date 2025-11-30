<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserResource;
use App\Http\Service\CompanyService;
use App\Http\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected UserService $userService;
    protected CompanyService $companyService;
    public function __construct(UserService $userService, CompanyService $companyService){
        $this->userService = $userService;
        $this->companyService = $companyService;
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user=$this->userService->getUserByEmail($request->email);
        if(!$user||!Hash::check($request->password,$user->password)){
            return response()->json(['message' => 'The provided credentials are incorrect.'],401);
        }
        $token=$user->createToken('authToken')->plainTextToken;
        return response()->json(['user'=>new UserResource($user),'token'=>$token],200);

    }
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|min:8',
            'phone'=>'required_if:role,company|unique:companies',
            'address'=>'required_if:role,company',
            'description'=>'required_if:role,company',
            'role'=> 'required|in:admin,company,student,alumni',
            'company_name'=>'required_if:role,company',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $user=$this->userService->addUser($request);
        if($request->role ==='company'){
            $company=$this->companyService->addCompany($request,$user->id);
        }
        $token=$user->createToken('authToken')->plainTextToken;
        return response()->json(['user'=>new UserResource($user),'token'=>$token],201);
    }

}
