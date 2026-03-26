<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\MenusController;
use App\Http\Controllers\Master\RolesController;
use App\Http\Controllers\Master\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/detail/{user:name}', [DashboardController::class, 'show'])->name('detail');

    Route::middleware('role:super-admin')->name('master.')->prefix('master')->group(function () {
        Route::resource('users', UsersController::class);
        Route::resource('menus', MenusController::class);
        Route::resource('roles', RolesController::class);
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
