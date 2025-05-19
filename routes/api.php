<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
//    return $request->user();
   // $user=\App\Models\User::findOrFail(1);
   // return $user->properties()->with('propertyable')->get();
});

//)->middleware('auth:sanctum');

Route::controller(AuthController::class)->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::post('/register', 'register')->name('register');
        Route::post('/login', 'login')->name('login');
        Route::middleware('auth:api')->post('/logout', 'logout')->name('logout');
        Route::middleware('auth:api')->post('/refresh', 'refresh')->name('refresh');
        Route::middleware('auth:api')->post('/me', 'me')->name('me');
    });
