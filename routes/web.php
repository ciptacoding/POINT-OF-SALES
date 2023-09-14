<?php

use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RiwayatTransaksiController;
use App\Http\Controllers\StokController;
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

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('barang', BarangController::class);
    Route::resource('distributor', DistributorController::class);
    Route::resource('stok', StokController::class);
    Route::resource('pengeluaran', PengeluaranController::class);
    Route::get('/searchbarang', [BarangController::class, 'search']);
    Route::get('/searchdistributor', [DistributorController::class, 'search']);
    Route::get('/searchstok', [StokController::class, 'search']);
    Route::get('/searchpengeluaran', [PengeluaranController::class, 'search']);

    Route::get('/transaksi/list', [TransaksiController::class, 'list'])->name('transaksi.list');
    Route::get('/transaksi/getAll', [TransaksiController::class, 'getAll'])->name('transaksi.get_all');
    Route::put('/transaksi/saveTransaction', [TransaksiController::class, 'saveTransaction'])->name('transaksi.save_transaction');
    Route::resource('transaksi', TransaksiController::class)->except(['create', 'edit']);

    Route::resource('riwayat-transaksi', RiwayatTransaksiController::class)->only(['index', 'show']);

    Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan-keuangan.index');
});
