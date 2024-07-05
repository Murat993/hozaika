<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LoyaltyController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLogController;
use App\Http\Controllers\UserProductSumController;
use App\Http\Controllers\UserTaskController;
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

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('managers', ManagerController::class)->except('show');
    Route::get('/logs', [UserLogController::class, 'index'])->name('logs.index');
});

Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::resource('users', UserController::class)->except('show');

    Route::get('/users/{user}/products', [UserProductSumController::class, 'index'])->name('users.products.index');
    Route::post('/users/{user}/products', [UserProductSumController::class, 'store'])->name('users.products.store');

    Route::resource('levels', LevelController::class)->except(['show','delete','edit','update']);
    Route::resource('tasks', TaskController::class)->except('show');

    Route::get('/users/{user}/tasks', [UserTaskController::class, 'index'])->name('users.tasks');
    Route::post('/users/{user}/tasks/{task}/complete', [UserTaskController::class, 'completeTask'])->name('users.tasks.complete');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/loyalty', [LoyaltyController::class, 'index'])->name('loyalty');
});



