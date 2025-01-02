<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register',[\App\Http\Controllers\v1\AuthController::class , 'register']);


Route::post('login',[\App\Http\Controllers\v1\AuthController::class, 'login']);

Route::get('user',[\App\Http\Controllers\v1\AuthController::class, 'fetchUser']);


Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('roles',[\App\Http\Controllers\v1\RoleController::class, 'roles']);
});