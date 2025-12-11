<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SanphamController;
use App\Http\Controllers\User\GiohangController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\User\ThanhtoanController;
use App\Http\Controllers\User\DashboardController;



//user
Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::prefix('thanhtoan')->controller(ThanhtoanController::class)->group((function () {
        Route::post('order', 'store')->name('thanhtoan.store');
        Route::get('momo_payment', 'momo_payment')->name('thanhtoan.momo');
        Route::get('momo/return', 'momo_return')->name('thanhtoan.momo.return');
    }));
});

// giỏ hàng
Route::prefix('giohang')->controller(GiohangController::class)->group(function () {
    Route::get('view', 'view')->name('giohang.view');
    Route::post('store/{sanpham}', 'store')->name('giohang.store');
    Route::patch('update/{sanpham}', 'update')->name('giohang.update');
    Route::delete('delete/{sanpham}', 'delete')->name('giohang.delete');
});


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

    Route::get('/loaisps', [\App\Http\Controllers\Admin\LoaispController::class, 'index'])->name('admin.loaisps.index');
    Route::post('/loaisps/store', [\App\Http\Controllers\Admin\LoaispController::class, 'store'])->name('admin.loaisps.store');
    Route::put('/loaisps/update/{id}', [\App\Http\Controllers\Admin\LoaispController::class, 'update'])->name('admin.loaisps.update');
    Route::delete('/loaisps/destroy/{id}', [\App\Http\Controllers\Admin\LoaispController::class, 'destroy'])->name('admin.loaisps.destroy');

    Route::get('/thuonghieus', [\App\Http\Controllers\Admin\ThuonghieuController::class, 'index'])->name('admin.thuonghieus.index');
    Route::post('/thuonghieus/store', [\App\Http\Controllers\Admin\ThuonghieuController::class, 'store'])->name('admin.thuonghieus.store');
    Route::put('/thuonghieus/update/{id}', [\App\Http\Controllers\Admin\ThuonghieuController::class, 'update'])->name('admin.thuonghieus.update');
    Route::delete('/thuonghieus/destroy/{id}', [\App\Http\Controllers\Admin\ThuonghieuController::class, 'destroy'])->name('admin.thuonghieus.destroy');
});

require __DIR__ . '/settings.php';
