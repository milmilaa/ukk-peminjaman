<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\MonitoringController;

use App\Http\Controllers\Siswa\DashboardController;
use App\Http\Controllers\Siswa\AlatController as SiswaAlatController;
use App\Http\Controllers\Siswa\CartController;
use App\Http\Controllers\Siswa\PeminjamanController as SiswaPeminjamanController;
use App\Http\Controllers\Siswa\PengembalianController as SiswaPengembalianController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    /* dashboard sesuai role */
    Route::get('/dashboard', function () {

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (auth()->user()->role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        }

        if (auth()->user()->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }

        abort(403);

    })->name('dashboard');


    /* dashboard view */
    Route::get('/admin/dashboard', function () {
        return view('dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    Route::get('/petugas/dashboard', function () {
        return view('dashboard');
    })->middleware('role:petugas')->name('petugas.dashboard');

    Route::get('/siswa/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:siswa')
        ->name('siswa.dashboard');


    /* admin only*/
    Route::middleware('role:admin')->group(function () {

        Route::resource('users', UserController::class);
        Route::resource('alat', AlatController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('peminjaman', PeminjamanController::class);
        Route::resource('pengembalian', PengembalianController::class);

        Route::get('monitoring/log', [MonitoringController::class, 'log'])
            ->name('monitoring.log');
    });


    /* petugas only */
    Route::middleware('role:petugas')->group(function () {

        Route::get('monitoring/menyetujui', [MonitoringController::class, 'menyetujui'])
            ->name('monitoring.menyetujui');

        Route::get('monitoring/pengembalian', [MonitoringController::class, 'pengembalian'])
            ->name('monitoring.pengembalian');

        Route::get('laporan/cetak', [LaporanController::class, 'cetak'])
            ->name('laporan.cetak');
    });


    /* siswa only */
    Route::middleware('role:siswa')->group(function () {

        Route::get('/siswa/alat', [SiswaAlatController::class, 'index'])
            ->name('siswa.alat');

        Route::get('/siswa/cart', [CartController::class, 'index'])
            ->name('siswa.cart');

        Route::post('/siswa/cart/add/{id}', [CartController::class, 'add'])
            ->name('siswa.cart.add');

        Route::post('/siswa/cart/remove/{id}', [CartController::class, 'remove'])
            ->name('siswa.cart.remove');

        Route::post('/siswa/peminjaman', [SiswaPeminjamanController::class, 'store'])
            ->name('siswa.peminjaman.store');

        Route::post('/siswa/pengembalian/{id}', [SiswaPengembalianController::class, 'store'])
            ->name('siswa.pengembalian');
    });

});
