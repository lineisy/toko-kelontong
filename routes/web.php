<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\StokController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'kasir.dashboard');
    }
    return redirect()->route('login'); // Redirect ke login jika belum auth

});


Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/produk', [ProdukController::class, 'index'])->name('admin.produk');
    Route::post('/admin/produk', [ProdukController::class, 'store'])->name('admin.produk.store');
    Route::put('/admin/produk/{id}', [ProdukController::class, 'update'])->name('admin.produk.update');
    Route::get('/admin/produk/{id}/stock', [StokController::class, 'index'])->name('admin.produk.stock');
    Route::delete('/admin/produk/{id}', [ProdukController::class, 'destroy'])->name('admin.produk.destroy');
    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('admin.kategori');
    Route::post('/admin/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::put('/admin/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');
    Route::post('/admin/stok', [StokController::class, 'store'])->name('admin.stok.store');
    Route::put('/admin/stok/{id}', [StokController::class, 'update'])->name('admin.stok.update');
    Route::delete('/admin/stok/{id}', [StokController::class, 'destroy'])->name('admin.stok.destroy');
    Route::get('/admin/transaksi', [AdminController::class, 'transaksi'])->name('admin.transaksi');
    Route::post('/admin/transaksi', [AdminController::class, 'storeTransaction'])->name('admin.transaksi.store');
    Route::get('/admin/laporan-transaksi', [AdminController::class, 'laporanTransaksi'])->name('admin.laporan.transaksi');
});

Route::middleware('auth', 'role:kasir')->group(function () {
    Route::get('/kasir', [KasirController::class, 'dashboard'])->name('kasir.dashboard');
    Route::get('/kasir/produk', [ProdukController::class, 'index'])->name('kasir.produk');
    Route::get('/kasir/kategori', [KategoriController::class, 'index'])->name('kasir.kategori');
    Route::get('/kasir/stok', [StokController::class, 'index'])->name('kasir.stok');
    Route::get('/kasir/transaksi', [KasirController::class, 'transaksi'])->name('kasir.transaksi');
    Route::post('/kasir/transaksi', [KasirController::class, 'storeTransaction'])->name('kasir.transaksi.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
