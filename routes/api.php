<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('add', [UserController::class, 'store']);
Route::get('get/{id}', [UserController::class, 'user']);
Route::post('remove/{id}', [UserController::class, 'delete']);
Route::get('users', [UserController::class, 'get']);
Route::post('edit/{id}', [UserController::class, 'update']);