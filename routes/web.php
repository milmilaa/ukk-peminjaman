<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;
use App\Http\Controllers\Admin\LogAktivitasController as AdminLogAktivitasController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

use App\Http\Controllers\Petugas\MonitoringController as PetugasMonitoringController;
use App\Http\Controllers\Petugas\LaporanController as PetugasLaporanController;
use App\Http\Controllers\Petugas\PengembalianController as PetugasPengembalianController;

use App\Http\Controllers\Medis\DashboardController as MedisDashboardController;
use App\Http\Controllers\Medis\AlatController as MedisAlatController;
use App\Http\Controllers\Medis\CartController;
use App\Http\Controllers\Medis\PeminjamanController as MedisPeminjamanController;
use App\Http\Controllers\Medis\PengembalianController as MedisPengembalianController;

use App\Http\Controllers\NotifController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return match (auth()->user()->role) {
        'admin'   => redirect()->route('admin.dashboard'),
        'petugas' => redirect()->route('petugas.dashboard'),
        'medis'   => redirect()->route('medis.dashboard'),
        default   => redirect()->route('login'),
    };

})->name('dashboard');

/*
|--------------------------------------------------------------------------
| MEDIS PUBLIC
|--------------------------------------------------------------------------
*/
Route::prefix('medis')->name('medis.')->group(function () {

    Route::get('/dashboard', [MedisDashboardController::class, 'index'])->name('dashboard');
    Route::get('/alat', [MedisAlatController::class, 'index'])->name('alat');

});

/*
|--------------------------------------------------------------------------
| AUTH MIDDLEWARE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/notif', [NotifController::class, 'index'])->name('notif.page');

    Route::post('/profile/photo', function () {

        $user = auth()->user();

        request()->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if (request()->hasFile('foto')) {

            if ($user->foto && file_exists(public_path($user->foto))) {
                unlink(public_path($user->foto));
            }

            $file = request()->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $filename);

            $user->foto = 'uploads/profile/'.$filename;
            $user->save();
        }

        return back()->with('success','Foto berhasil diupdate');

    })->name('profile.photo.update');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('users', UserController::class);
        Route::resource('alat', AlatController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('peminjaman', PeminjamanController::class);
        Route::resource('pengembalian', PengembalianController::class);

        // ✅ FIX EXPORT ADMIN
        Route::get('/peminjaman/export/excel', [PeminjamanController::class, 'exportExcel'])
            ->name('peminjaman.export.excel');

        Route::get('/monitoring/log', [AdminLogAktivitasController::class, 'index'])
            ->name('monitoring.log');
    });

/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/
Route::middleware(['role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', [PetugasMonitoringController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/peminjaman', [PetugasMonitoringController::class, 'menyetujui'])
            ->name('menyetujui');

        Route::post('/setujui/{id}', [PetugasMonitoringController::class, 'setujui'])
            ->name('setujui');

        Route::post('/tolak/{id}', [PetugasMonitoringController::class, 'tolak'])
            ->name('tolak');

        Route::get('/monitoring', [PetugasMonitoringController::class, 'monitoring'])
            ->name('monitoring');

        Route::get('/pengembalian', [PetugasMonitoringController::class, 'pengembalian'])
            ->name('pengembalian');

        Route::post('/pengembalian/{id}', [PetugasPengembalianController::class, 'store'])
            ->name('pengembalian.store');

        // LAPORAN
        Route::get('/cetak/peminjaman', [PetugasLaporanController::class, 'cetakPeminjaman'])
            ->name('cetak.peminjaman');

        Route::get('/cetak/pengembalian', [PetugasLaporanController::class, 'cetakPengembalian'])
            ->name('cetak.pengembalian');

        Route::get('/peminjaman/export/excel', [PetugasLaporanController::class, 'excel'])
            ->name('peminjaman.export.excel');

        // DENDA
        Route::post('/pengembalian/{id}/bayar-denda', [PetugasPengembalianController::class, 'bayarDenda'])
            ->name('pengembalian.bayar-denda');

        Route::get('/laporan/denda', [PetugasLaporanController::class, 'laporanDenda'])
            ->name('laporan.denda');

        Route::get('/laporan/denda/excel', [PetugasLaporanController::class, 'exportDendaExcel'])
            ->name('laporan.denda.excel');

        Route::get('/laporan/denda/pdf', [PetugasLaporanController::class, 'exportDendaPdf'])
            ->name('laporan.denda.pdf');

        Route::get('/invoice/denda/{id}', [PetugasLaporanController::class, 'invoiceDenda'])
            ->name('invoice.denda');
    });

/*
|--------------------------------------------------------------------------
| MEDIS
|--------------------------------------------------------------------------
*/
Route::middleware(['role:medis'])
    ->prefix('medis')
    ->name('medis.')
    ->group(function () {

        Route::get('/dashboard', [MedisDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/aktivitas', [MedisPeminjamanController::class, 'aktivitas'])
            ->name('aktivitas');

        Route::get('/cart', [CartController::class, 'index'])->name('cart');

        Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
        Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
        Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

        Route::post('/peminjaman', [MedisPeminjamanController::class, 'store'])
            ->name('peminjaman.store');

        Route::post('/pengembalian/{id}', [MedisPengembalianController::class, 'store'])
            ->name('pengembalian.store');
    });

});
