<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
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
    Route::get("/application/jobs/{job}",[\App\Http\Controllers\ApplicationController::class,'getApplicationsForJob']);


});
Route::middleware('auth:sanctum,role:student')->group(function () {
    Route::post("/application/add",[\App\Http\Controllers\ApplicationController::class,'store']);
    Route::put("/application/update/{application}",[\App\Http\Controllers\ApplicationController::class,'update']);
    Route::delete("/application/delete/{application}",[\App\Http\Controllers\ApplicationController::class,'destroy']);
    Route::get("/application/user",[\App\Http\Controllers\ApplicationController::class,'getApplicationsForUser']);





});


Route::middleware('auth:sanctum,role:student,alumni,admin')->group(function () {
    Route::get("/companies/name",[CompanyController::class,'searchCompany']);
    Route::get("/jobs/name",[JobController::class,'searchJobs']);
    Route::get("/comments/company/{companyId}",[CommentController::class,'getCommentsForCompany']);
    Route::delete("/comments/{comment}",[CommentController::class,'destroy']);
});
Route::middleware('auth:sanctum,role:student,alumni')->group(function () {
    Route::post("/comment/add",[CommentController::class,'store']);
    Route::put("/comment/update/{comment}",[CommentController::class,'update']);

});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/jobs/company/{company_id}',[JobController::class,'getJobsForCompany']);
    Route::get("/comment/{companyId}",[\App\Http\Controllers\CommentController::class,'getCommentsForCompany']);
    Route::get("/comments/user",[CommentController::class,'getCommentsForUser']);


});



