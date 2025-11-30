<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register'] );
Route::post('/login', [AuthController::class, 'login'] );

Route::middleware('auth:sanctum,role:admin')->group(function () {

});
Route::middleware('auth:sanctum,role:company')->group(function () {
    Route::get("/users/{role}/role",[UserController::class,'getUsersForRole']);
});
Route::middleware('auth:sanctum,role:student,alumni')->group(function () {

});
