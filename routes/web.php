<?php

use App\Http\Controllers\User\TaskController;
use App\Http\Controllers\User\Auth\UserController;
use Illuminate\Support\Facades\Route;
use PhpOption\Some;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('User')->middleware('backbutton')->group(function () {
    Route::namespace('Auth')->middleware('guest')->group(function () {
        Route::resource('user', 'UserController');
        Route::get('/', function () {
            // $obj = [
            //     'name' => 'anuj',
            //     'email' => 'anuj@gmail.com'
            // ];
            // dd($obj);
            return view('User.login');
        })->name('user.Login');
        Route::post('user-login', [UserController::class, 'userLogin'])->name('user.Logins');
        Route::get('user-logout', [UserController::class, 'userLogout'])->withoutMiddleware('guest')->name('user.Logout');
    });
    Route::middleware('userAuth:user')->group(function () {
        Route::get('user-dashboard', [UserController::class, 'userDashboard'])->name('user.Dashboard');
        Route::post('comment', [TaskController::class, 'newComment'])->name('add.Comment');
        Route::post('update-comment', [TaskController::class, 'updateComment'])->name('update.Comment');
        Route::get('overdue', [TaskController::class, 'overDue'])->name('task.Overdue');
        Route::get('/get-comment/{id}', [TaskController::class, 'getComment'])->name('get.comment');
        Route::resource('task', 'TaskController');
    });
});
