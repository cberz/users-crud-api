<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class,'login']);

Route::get('/users', [App\Http\Controllers\UserController::class,'index']);

Route::middleware('auth:sanctum')->group(function () {

  Route::post('/logout',[App\Http\Controllers\Auth\LogoutController::class,'logout']);

  Route::apiResource('users',App\Http\Controllers\UserController::class)
    ->except(['index']);

});
