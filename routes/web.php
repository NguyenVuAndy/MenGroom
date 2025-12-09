<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SanphamController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\Admin\AdminAuthController;

//user

Route::get('/', [UserController::class, 'index'])->name('user.home');


// admin

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'admin', 'middleware' => 'redirectAdmin'], function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/sanphams', [SanphamController::class, 'index'])->name('admin.sanphams.index');
    Route::post('/sanphams/store', [SanphamController::class, 'store'])->name('admin.sanphams.store');
    Route::put('/sanphams/update/{id}', [SanphamController::class, 'update'])->name('admin.sanphams.update');
    Route::delete('/sanphams/destroy/{id}', [SanphamController::class, 'destroy'])->name('admin.sanphams.destroy');
});

require __DIR__ . '/settings.php';
