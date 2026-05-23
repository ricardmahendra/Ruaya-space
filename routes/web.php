<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StokKeluarController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kategoris', KategoriController::class)->middleware('role:admin');
    Route::resource('suppliers', SupplierController::class)->middleware('role:admin');
    Route::resource('barangs', BarangController::class);
    Route::get('barangs/{barang}/detail', [BarangController::class, 'detail'])->name('barangs.detail');
    Route::get('api/search-barang', [BarangController::class, 'searchApi'])->name('api.search');

    Route::resource('stok-masuk', StokMasukController::class)->except(['show', 'edit', 'update', 'destroy']);
    Route::resource('stok-keluar', StokKeluarController::class)->except(['show', 'edit', 'update', 'destroy']);

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/stok', [LaporanController::class, 'stok'])->name('stok');
        Route::get('/masuk', [LaporanController::class, 'masuk'])->name('masuk');
        Route::get('/keluar', [LaporanController::class, 'keluar'])->name('keluar');
        Route::get('/fifo', [LaporanController::class, 'fifo'])->name('fifo');
        Route::get('/menipis', [LaporanController::class, 'menipis'])->name('menipis');
        Route::get('/export-pdf/{type}', [LaporanController::class, 'exportPdf'])->name('exportPdf');
        Route::get('/export-excel/{type}', [LaporanController::class, 'exportExcel'])->name('exportExcel');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
