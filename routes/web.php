<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Import Model cukup satu kali di atas
use App\Models\admin\Produk;
use App\Models\admin\Supplier;
use App\Models\admin\Penjualan;
use App\Models\admin\Pembelian;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// Grouping Middleware Auth agar lebih rapi
Route::middleware('auth')->group(function () {
    // Resource Routes
    Route::resource('produk', ProdukController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('bahan-baku', BahanBakuController::class);
    Route::resource('pembelian', PembelianController::class);
    Route::resource('penjualan', PenjualanController::class);

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';