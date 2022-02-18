<?php

use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', LoginController::class)->name('login');
    Route::get('register', RegisterController::class)->name('register');

    Route::post('login', [LoginController::class, 'store']);
    Route::post('register', [RegisterController::class, 'store']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', fn () => redirect()->route('dashboard.user'));
    Route::post('logout', LogoutController::class)->name('logout');

    Route::prefix('data')->group(function () {
        Route::get('todo', [TodoController::class, 'data'])->name('todo.data');
    });

    Route::prefix('dashboard')->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/', [DashboardUserController::class, 'index'])->name('dashboard.user');
        });
    });

    Route::put('todo/update-status/{todo:id}', [TodoController::class, 'update_status'])->name('todo.update-status');
    Route::put('todo/update-multiple', [TodoController::class, 'update_multiple'])->name('todo.update-multiple');
    Route::delete('todo/delete-multiple', [TodoController::class, 'delete_multiple'])->name('todo.delete-multiple');
    Route::resource('todo', TodoController::class);
});
