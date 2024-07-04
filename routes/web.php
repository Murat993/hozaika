<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoyaltyController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [HomeController::class, 'index'])->middleware('auth');

Auth::routes();

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::group([
        'as' => 'admin.',
    ], function () {
        Route::resource('users', UserController::class)->except('show');
        Route::resource('managers', ManagerController::class)->except('show');
        Route::get('/logs', [UserLogController::class, 'index'])->name('logs.index');
    });
});

Route::middleware(['auth', 'role:manager'])->prefix('manager')->group(function () {
    Route::group([
        'as' => 'manager.',
    ], function () {
        Route::resource('users', UserController::class)->except('show');
    });
});

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::group([
        'as' => 'user.',
    ], function () {
        Route::get('/loyalty', [LoyaltyController::class, 'index'])->name('loyalty');
    });
});



