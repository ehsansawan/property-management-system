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
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SubscriptionController;
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

//Profile
Route::controller(ProfileController::class)->prefix('profile')
    ->name('profile.')
    ->middleware([JwtMiddleware::class])
    ->group(function () {
        Route::post('/create', 'create')->name('create');
        Route::get('/show', 'show')->name('show');
        Route::post('/update', 'update')->name('update');
        Route::delete('/delete', 'delete')->name('delete');
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
 //ads
    Route::controller(\App\Http\Controllers\AdController::class)->prefix('ad')
        ->name('ad.')
        ->group(function () {
            Route::get('/index', 'index')->name('index');
            Route::post('/create', 'create')->name('create');
            Route::get('/activate/{id}','activate')->name('activate');
            Route::get('show/{id}', 'show')->name('show');
            Route::get('unactivate/{id}','unactivate')->name('unactivate');
            Route::post('getAdsByPropertyType','getAdsByPropertyType')->name('getAdsByPropertyType');
            Route::post('getUserAds','getUserAds')->name('getUserAds');
            Route::post('activateSelectedAds','activateSelectedAds')->name('activateSelectedAds');
            Route::delete('delete/{id}','delete')->name('delete');
            Route::post('nearToYou','nearToYou')->name('nearToYou');
        });
});


/*********************************************************************
 *                           yahia routes                            *
 *********************************************************************/


Route::middleware(JwtMiddleware::class)
    ->controller(SubscriptionController::class)                     ->prefix('subscriptions')
                                                                    ->name('subscriptions.')
    ->group(function () {

    Route::get('/activated/admin', 'allActiveSub')                  ->name('allActiveSub');
    Route::get('/admin', 'index')                                   ->name('index.admin');
    Route::put('/deactivate/{id}/admin', 'deactivate')              ->name('deactivate.admin');
    Route::get('/{id}/admin', 'show')                               ->name('show.admin');
    Route::delete('/{id}/admin', 'destroy')                         ->name('destroy.admin');

    Route::get('/active/client', 'userActiveSub')                   ->name('activeSub.client');
    Route::put('/deactivate/client', 'userDeactivate')              ->name('deactivate.client');
    Route::get('/client', 'userIndex')                              ->name('index.client');
    Route::get('/{id}/client', 'userShow')                          ->name('show.client');
    Route::post('/client', 'userCreate')                            ->name('store.client');
    Route::get('/time_remaining/{id}/client', 'time_remaining')     ->name('timeRemaining.client');
});


Route::middleware(JwtMiddleware::class)
     ->controller(ReviewController::class)
                                                                    ->name('reviews.')
     ->group(function () {

    Route::get('/reviews', 'index')                                 ->name('index');
    Route::post('/reviews', 'user_store')                           ->name('store');
    Route::get('/reviews/{id}', 'show')                             ->name('show');
    Route::put('/reviews/{id}', 'user_update')                      ->name('update');
    Route::delete('/reviews/{id}', 'destroy')                       ->name('destroy');
    Route::delete('/client/reviews/{id}', 'client_destroy')         ->name('client_destroy');
    Route::get('/property/{property_id}/reviews', 'property_index') ->name('property.index');
});

Route::middleware(JwtMiddleware::class)
     ->controller(\App\Http\Controllers\PlanController::class)
                                                                    ->name('plans.')
     ->group(function () {

    Route::get('/plans/yearly_plans', 'getYearlyPlans')             ->name('yearlyPlans');
    Route::get('/plans/monthly_plans', 'getMonthlyPlans')           ->name('monthlyPlans');
    Route::get('/plans', 'index')                                   ->name('index');
    Route::post('/plans', 'store')                                  ->name('store');
    Route::get('/plans/{id}', 'show')                               ->name('show');
    Route::put('/plans/{id}', 'update')                             ->name('update');
    Route::delete('/plans/{id}', 'destroy')                         ->name('destroy');
});

Route::middleware(JwtMiddleware::class)
     ->controller(FavoriteController::class)
                                                                    ->prefix('favorites')
                                                                    ->name('favorite.')
     ->group(function () {

    Route::get('/', 'index')                                        ->name('index');
    Route::post('/{id}', 'add')                                     ->name('add');
    Route::delete('/{id}', 'remove')                                ->name('remove');
    Route::get('/{id}', 'IsInFavorites')                            ->name('check');
});

/*****************************  end here  ****************************/


