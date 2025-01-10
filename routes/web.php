<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CmotController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Counter;

Route::group(['middleware' => 'guest'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('login',     'index')->name('login');
        Route::post('login',    'login')->name('login'); //->middleware('throttle:2,1')
    });
});

Route::get('resetPassword',       [AuthController::class, 'resetPwdView'])->name('resetPassword');
Route::post('resetPassword',      [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::get('sendOtp',             [AuthController::class, 'sendOtpView'])->name('sendOtp');
Route::post('sendOtp',            [AuthController::class, 'sendOtp'])->name('sendOtp');
Route::get('verifyOtp',           [AuthController::class, 'verifyOtpView'])->name('verifyOtp');
Route::post('verifyOtp',          [AuthController::class, 'verifyOtp'])->name('verifyOtp');
Route::get('changePassword',      [AuthController::class, 'changePasswordView'])->name('changePassword');
Route::post('changePassword',     [AuthController::class, 'changePassword'])->name('changePassword');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/',                 [WelcomeController::class, 'index']);
    Route::get('home',              [AuthController::class, 'home'])->name('home');
    Route::get('logout',            [AuthController::class, 'logout'])->name('logout');

    Route::resources([
        'roles'             =>  RoleController::class,
        'users'             =>  UserController::class,
        'permissions'       =>  PermissionController::class,
    ]);

    Route::controller(UserController::class)->group(function () {
        Route::get('user-search',       'search')->name('user.search');
    });
    Route::get('permission_search',     [PermissionController::class, 'search'])->name('permissions.search');

});

// Route::get('social-media', function () {
//     return view('social-media');
// });

Route::fallback(function () {
    return abort(401, "User can't perform this action.");
});