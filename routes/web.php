<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AreaParkirController as AdminAreaParkirController;
use App\Http\Controllers\Admin\KendaraanController as AdminKendaraanController;
use App\Http\Controllers\Admin\LogAktivitasController as AdminLogAktivitasController;
use App\Http\Controllers\Admin\TarifController as AdminTarifController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Owner\OwnerDashboardController;
use App\Http\Controllers\Owner\RekapTransaksiController;
use App\Http\Controllers\Petugas\PetugasDashboardController;
use App\Http\Controllers\Petugas\TransaksiDemoController;

// Landing page = Login
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    // Redirect dashboard -> dashboard sesuai role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::resource('tarif', AdminTarifController::class)->except(['show']);
        Route::resource('area-parkir', AdminAreaParkirController::class)->except(['show']);
        Route::resource('kendaraan', AdminKendaraanController::class)->except(['show']);

        Route::get('log-aktivitas', [AdminLogAktivitasController::class, 'index'])->name('log-aktivitas.index');
    });

    Route::prefix('owner')->name('owner.')->middleware('role:owner')->group(function () {
        Route::get('/dashboard', OwnerDashboardController::class)->name('dashboard');
        Route::get('/rekap-transaksi', [RekapTransaksiController::class, 'index'])->name('rekap.index');
    });

    Route::prefix('petugas')->name('petugas.')->middleware('role:petugas')->group(function () {
        Route::get('/dashboard', PetugasDashboardController::class)->name('dashboard');
        // Demo transaksi (belum full integrasi deteksi AI)
        Route::get('/transaksi-demo', [TransaksiDemoController::class, 'index'])->name('transaksi.demo');
    });
});
