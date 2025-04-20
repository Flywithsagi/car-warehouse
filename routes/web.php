<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\MobilController;

// Route Halaman Dashboard
// Rute untuk menampilkan halaman dashboard utama, mengarah ke method 'index' pada WelcomeController
Route::get('/', [WelcomeController::class, 'index']);

// Route Halaman Jenis
Route::prefix('jenis')->group(function () {
    // Menampilkan daftar jenis
    Route::get('/', [JenisController::class, 'index']);
    // Mengambil daftar jenis kendaraan dalam format JSON (untuk DataTables)
    Route::post('/list', [JenisController::class, 'list']);
    // Menampilkan form untuk menambah jenis kendaraan
    Route::get('/create', [JenisController::class, 'create']);
    // Menyimpan jenis kendaraan baru
    Route::post('/store', [JenisController::class, 'store']);
    // Menampilkan detail jenis berdasarkan ID
    Route::get('/{id}/show', [JenisController::class, 'show']);
    // Menampilkan form untuk mengedit jenis kendaraan
    Route::get('/{id}/edit', [JenisController::class, 'edit']);
    // Memperbarui data jenis kendaraan berdasarkan ID
    Route::put('/{id}/update', [JenisController::class, 'update']);
    // Menampilkan halaman konfirmasi untuk menghapus jenis berdasarkan ID
    Route::get('/{id}/delete', [JenisController::class, 'confirm']);
    // Menghapus jenis kendaraan berdasarkan ID
    Route::delete('/{id}/delete', [JenisController::class, 'delete']);
});

// Route Halaman data Mobil
// Prefix 'mobil' digunakan untuk mengelompokkan semua route terkait mobil
Route::prefix('mobil')->group(function () {
    // Menampilkan daftar mobil
    Route::get('/', [MobilController::class, 'index']);
    // Mengambil daftar mobil dalam format JSON (untuk DataTables)
    Route::post('/list', [MobilController::class, 'list']);
    // Menampilkan form untuk menambah mobil baru
    Route::get('/create', [MobilController::class, 'create']);
    // Menyimpan data mobil baru
    Route::post('/store', [MobilController::class, 'store']);
    // Menampilkan detail mobil berdasarkan ID
    Route::get('/{id}/show', [MobilController::class, 'show']);
    // Menampilkan form untuk mengedit data mobil
    Route::get('/{id}/edit', [MobilController::class, 'edit']);
    // Memperbarui data mobil berdasarkan ID
    Route::put('/{id}/update', [MobilController::class, 'update']);
    // Menampilkan halaman konfirmasi untuk menghapus mobil berdasarkan ID
    Route::get('/{id}/delete', [MobilController::class, 'confirm']);
    // Menghapus data mobil berdasarkan ID
    Route::delete('/{id}/delete', [MobilController::class, 'delete']);
});
