<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\VerifiedEmail;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
//    return $request->user();
   // $user=\App\Models\User::findOrFail(1);
   // return $user->properties()->with('propertyable')->get();
});

//)->middleware('auth:sanctum');

//Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//    $request->fulfill();
//    event(new Verified(\App\Models\User::query()->find($request->route('id'))));
//    return \App\Http\Responses\Response::Success(true,'Email is verified');
//})->middleware(['auth:api','signed'])->name('verification.verify');


Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $user = User::findOrFail($request->route('id'));

    if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
        return response()->json(['message' => 'Invalid verification link'], 403);
    }

    if ($user->hasVerifiedEmail()) {
        return response()->json(['message' => 'Email already verified'], 200);
    }

    $user->markEmailAsVerified();
    event(new Verified($user));
    //this two line is instead of $request->fullfill() because it redirect to route login

    return response()->json(['message' => 'Email verified successfully'], 200);
})
    ->middleware(['signed'])->name('verification.verify');

// resend verification email
Route::post('/email/verification-notification', function (Request $request) {
   $request->user()->sendEmailVerificationNotification();
   return \App\Http\Responses\Response::Success(true,'Verification link sent!');
})
    ->middleware(['auth:api','throttle:6,1'])->name('verification.send');


//auth
Route::controller(AuthController::class)->prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::post('/register', 'register')->name('register');
        Route::post('/login', 'login')->name('login');
        Route::middleware('auth:api')->post('/logout', 'logout')->name('logout');
        Route::middleware('auth:api')->post('/refresh', 'refresh')->name('refresh');
        Route::middleware('auth:api')->post('/me', 'me')->name('me');
        Route::post('/forgetPassword','forgetPassword')->name('forgetPassword');
        Route::post('/resetPassword','resetPassword')->name('resetPassword');
        Route::post('/checkCode','checkCode')->name('checkCode');
    });

Route::middleware([JwtMiddleware::class,VerifiedEmail::class])->group(function () {

// User
Route::controller(UserController::class)->prefix('user')
        ->name('user.')
        ->group(function () {
            Route::get('/getUsers', 'get_users')->name('getUsers');
            Route::post('/create', 'create')->name('create');
            Route::get('/show/{id}', 'show')->name('show');
            Route::post('update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });
//Profile
Route::controller(ProfileController::class)->prefix('profile')
        ->name('profile.')
        ->group(function () {
            Route::post('/create', 'create')->name('create');
            Route::get('/show', 'show')->name('show');
            Route::post('/update', 'update')->name('update');
            Route::delete('/delete', 'delete')->name('delete');
        });
//property
Route::controller(\App\Http\Controllers\PropertyController::class)->prefix('property')
->name('property.')
    ->group(function () {
        Route::get('/getProperty/{id}','getProperty')->name('getProperty');
       Route::get('/getUserProperties', 'getUserProperties')->name('getUserProperties');
       Route::post('/create', 'create')->name('create');
       Route::post('/getAttributes','getAttributes')->name('getAttributes');
       Route::post('/update/{id}', 'update')->name('update');
       Route::delete('/delete/{id}', 'delete')->name('delete');
    });
//location
Route::controller(LocationController::class)->prefix('location')
    ->name('location.')
    ->group(function () {
       Route::get('/index', 'index')->name('index');
       Route::post('/create', 'create')->name('create');
       Route::post('/update/{id}', 'update')->name('update');
       Route::delete('/delete/{id}', 'delete')->name('delete');
    });
//governorate
Route::controller(\App\Http\Controllers\GovernorateController::class)->prefix('governorate')
    ->name('governorate.')
    ->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::post('/create', 'create')->name('create');
        Route::post('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });
//city
Route::controller(\App\Http\Controllers\CityController::class)->prefix('city')
    ->name('city.')
    ->group(function () {
       Route::get('show/{id}', 'show')->name('show');
       Route::get('getCitiesByGovernorate/{governorate_id}', 'getCitiesByGovernorate')->name('getCitiesByGovernorate');
       Route::post('/create', 'create')->name('create');
       Route::post('/update/{id}', 'update')->name('update');
       Route::delete('/delete/{id}', 'delete')->name('delete');
    });
//suggested location
 Route::controller(\App\Http\Controllers\SuggestedLocationController::class)->prefix('suggested-location')
     ->name('suggested-location.')
     ->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::post('/suggestedLocationsByGovernorate','suggestedLocationsByGovernorate')->name('suggestedLocationsByGovernorate');
        Route::post('/userSuggestedLocations','userSuggestedLocations')->name('userSuggestedLocations');
         Route::post('/create', 'create')->name('create');
         Route::post('/update/{id}', 'update')->name('update');
        Route::get('/show/{id}', 'show')->name('show');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::post('/approve/{id}', 'approve')->name('approve');
     });
});






