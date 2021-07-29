<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransactionController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::middleware(['admin'])->group(function () {
        Route::resource('admin', AdminController::class);
        Route::resource('book',BookController::class);
    });

    Route::middleware(['user'])->group(function () {
        Route::get('user', [UserController::class, 'index']);
    });

    Route::get('transaction/{id}/autofill', [TransactionController::class, 'autofill']);
    Route::resource('transaction',TransactionController::class);

    Route::get('/logout', function() {
        Auth::logout();
        redirect('/');
    });

});
