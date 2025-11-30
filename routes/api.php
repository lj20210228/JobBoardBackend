<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register'] );
Route::post('/login', [AuthController::class, 'login'] );

Route::middleware('auth:sanctum,role:admin')->group(function () {
    Route::delete("/user/delete/{user}", [UserController::class, 'destroy'] );
    Route::delete("/company/delete/{company}", [CompanyController::class, 'destroy'] );

});
Route::middleware('auth:sanctum,role:company')->group(function () {
    Route::get("/users/{role}/role",[UserController::class,'getUsersForRole']);
    Route::put("/company/update/{company}",[CompanyController::class,'update']);
    Route::post("job/add",[JobController::class,'store']);
    Route::put("job/update/{job}",[JobController::class,'update']);
    Route::delete("job/delete/{job}",[JobController::class,'destroy']);

});
Route::middleware('auth:sanctum,role:student,alumni')->group(function () {

});


Route::middleware('auth:sanctum,role:student,alumni,admin')->group(function () {
    Route::get("/companies/name",[CompanyController::class,'searchCompany']);
    Route::get("/jobs/name",[JobController::class,'searchJobs']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/jobs/company/{company_id}',[JobController::class,'getJobsForCompany']);
});

