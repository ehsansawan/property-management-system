<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
//    return $request->user();
   // $user=\App\Models\User::findOrFail(1);
   // return $user->properties()->with('propertyable')->get();
});

//)->middleware('auth:sanctum');

Route::controller(AuthController::class)->prefix('auth')
    ->name('auth.')
    ->group(function () {

        Route::post('/register', 'register')->name('register');
        Route::post('/login', 'login')->name('login');
        Route::middleware('auth:api')->post('/logout', 'logout')->name('logout');
        Route::middleware('auth:api')->post('/refresh', 'refresh')->name('refresh');
        Route::middleware('auth:api')->post('/me', 'me')->name('me');
    });


Route::controller(UserController::class)->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/getUsers', 'get_users')->name('getAllUsers');
        Route::get('/getUser/{id}', 'show')->name('show');
        Route::post('/create', 'create')->name('createUser');
        Route::post('update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });



