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
use App\Http\Controllers\Petugas\TransaksiController as PetugasTransaksiController;
use App\Http\Controllers\Petugas\TransaksiKeluarController;
use App\Http\Controllers\Petugas\TransaksiMasukController;
use App\Http\Controllers\Admin\CameraSourceController as AdminCameraSourceController;
use App\Http\Controllers\Petugas\CameraApiController;

// Landing page = Login
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});




Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    // Redirect dashboard -> dashboard sesuai role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::resource('tarif', AdminTarifController::class)->except(['show']);
        Route::resource('area-parkir', AdminAreaParkirController::class)->except(['show']);
        Route::resource('kendaraan', AdminKendaraanController::class)->except(['show']);
        Route::resource('camera-sources', AdminCameraSourceController::class)->except(['show']);

        Route::get('log-aktivitas', [AdminLogAktivitasController::class, 'index'])->name('log-aktivitas.index');
    });






    Route::prefix('owner')->name('owner.')->middleware('role:owner')->group(function () {
        Route::get('/dashboard', OwnerDashboardController::class)->name('dashboard');
        Route::get('/rekap-transaksi', [RekapTransaksiController::class, 'index'])->name('rekap.index');
        Route::get('/rekap-transaksi/{date}', [RekapTransaksiController::class, 'show'])->name('rekap.show');
    });

    Route::prefix('petugas')->name('petugas.')->middleware('role:petugas')->group(function () {
        Route::get('/dashboard', PetugasDashboardController::class)->name('dashboard');
        Route::get('/kamera', fn () => view('petugas.kamera.index', ['title' => 'Monitoring Kamera - Petugas']))->name('kamera.index');

        Route::get('/transaksi', [PetugasTransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/{transaksi}/karcis', [PetugasTransaksiController::class, 'karcis'])->name('transaksi.karcis');
        Route::get('/transaksi/{transaksi}/struk', [PetugasTransaksiController::class, 'struk'])->name('transaksi.struk');

        Route::get('/transaksi-masuk', [TransaksiMasukController::class, 'create'])->name('transaksi.masuk');
        Route::post('/transaksi-masuk', [TransaksiMasukController::class, 'store'])->name('transaksi.masuk.store');

        Route::get('/transaksi-keluar', [TransaksiKeluarController::class, 'create'])->name('transaksi.keluar');
        Route::post('/transaksi-keluar/scan', [TransaksiKeluarController::class, 'scan'])->name('transaksi.keluar.scan');
        Route::post('/transaksi-keluar/bayar', [TransaksiKeluarController::class, 'bayar'])->name('transaksi.keluar.bayar');
    });

    // API sederhana untuk petugas mengambil kamera aktif
    Route::get('/api/cameras/active', [CameraApiController::class, 'active'])
        ->name('petugas.cameras.active')
        ->middleware('role:petugas');
});
