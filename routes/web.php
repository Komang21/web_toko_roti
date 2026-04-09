<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use Illuminate\Support\Facades\Route;

// Import Model cukup satu kali di atas
use App\Models\admin\Produk;
use App\Models\admin\Supplier;
use App\Models\admin\Penjualan;
use App\Models\admin\Pembelian;

Route::get('/', function () {
    return view('welcome');
});

// Route Dashboard Tunggal
Route::get('/dashboard', function () {
    // 1. Ambil data asli dari database
    $totalProduk = Produk::count();
    $totalSupplier = Supplier::count();
    $totalPenjualan = Penjualan::count();
    
    // 2. Total Pendapatan
$totalPendapatan = Penjualan::sum('total');

    // 3. Data Placeholder untuk Grafik
    $labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
    $dataStokMasuk = [0, 0, 0, 0, 0, 0, 0]; 
    $dataStokKeluar = [0, 0, 0, 0, 0, 0, 0];

    return view('dashboard', compact(
        'totalProduk', 
        'totalSupplier', 
        'totalPenjualan', 
        'totalPendapatan',
        'labels',
        'dataStokMasuk',
        'dataStokKeluar'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

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