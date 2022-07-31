<?php

use App\Http\Controllers\User\Auth\UserController;
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

Route::resource('user', 'UserController');
Route::group(['middleware' => 'api'], function ($router) {
    Route::post('login', [UserController::class, 'userLogin']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('refresh', [UserController::class, 'refresh']);
    Route::post('me', [UserController::class, 'me']);
    Route::get('dashboard', [UserController::class, 'getDashboard']);
    Route::post('forgot-password', [UserController::class, 'forgotPassword']);
    Route::post('verify-otp', [UserController::class, 'verifyOTP']);
    Route::post('set-password', [UserController::class, 'setPassword']);
});
