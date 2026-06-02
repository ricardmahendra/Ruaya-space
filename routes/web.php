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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role:admin');
    Route::get('/activity-logs', [DashboardController::class, 'activityLogs'])->name('activity-logs.index')->middleware('role:admin');

    Route::resource('kategoris', KategoriController::class)->middleware('role:admin');
    Route::resource('suppliers', SupplierController::class)->middleware('role:admin');
    Route::resource('barangs', BarangController::class);
    Route::get('barangs/{barang}/detail', [BarangController::class, 'detail'])->name('barangs.detail');
    Route::get('api/search-barang', [BarangController::class, 'searchApi'])->name('api.search');

    Route::resource('stok-masuk', StokMasukController::class)->except(['show', 'edit', 'update', 'destroy']);
    Route::resource('stok-keluar', StokKeluarController::class)->except(['show', 'edit', 'update', 'destroy']);

    Route::middleware('role:admin')->group(function () {
        Route::resource('menus', App\Http\Controllers\MenuController::class);
        Route::resource('menu-recipes', App\Http\Controllers\MenuRecipeController::class)->except(['show']);
    });

    Route::middleware('role:kasir')->prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\KasirController::class, 'dashboard'])->name('dashboard');
        Route::get('/pos', [App\Http\Controllers\KasirController::class, 'pos'])->name('pos');
        Route::post('/pos/add-to-cart', [App\Http\Controllers\KasirController::class, 'addToCart'])->name('pos.add');
        Route::put('/pos/cart/{menu}', [App\Http\Controllers\KasirController::class, 'updateCart'])->name('pos.update');
        Route::delete('/pos/cart/{menu}', [App\Http\Controllers\KasirController::class, 'removeFromCart'])->name('pos.remove');
        Route::post('/pos/checkout', [App\Http\Controllers\KasirController::class, 'checkout'])->name('pos.checkout');
        Route::get('/menu-stock', [App\Http\Controllers\KasirController::class, 'menuStock'])->name('menu-stock');
        Route::get('/history', [App\Http\Controllers\KasirController::class, 'history'])->name('history');
        Route::get('/receipt/{sale}', [App\Http\Controllers\KasirController::class, 'receipt'])->name('receipt');
    });

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
