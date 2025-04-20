<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\MobilController;

// Route Halaman Dashboard
Route::get('/', [WelcomeController::class, 'index']); // Rute untuk menampilkan halaman dashboard utama

// Route Halaman Jenis
Route::prefix('jenis')->group(function () {
    Route::get('/', [JenisController::class, 'index']); // Menampilkan daftar jenis
    Route::post('/list', [JenisController::class, 'list']); // Mengambil daftar jenis kendaraan dalam format JSON (untuk DataTables)
    Route::get('/create', [JenisController::class, 'create']); // Menampilkan form untuk menambah jenis kendaraan
    Route::post('/store', [JenisController::class, 'store']); // Menyimpan jenis kendaraan baru
    Route::get('/{id}/show', [JenisController::class, 'show']); // Menampilkan detail jenis berdasarkan ID
    Route::get('/{id}/edit', [JenisController::class, 'edit']); // Menampilkan form untuk mengedit jenis kendaraan
    Route::put('/{id}/update', [JenisController::class, 'update']); // Memperbarui data jenis kendaraan berdasarkan ID
    Route::get('/{id}/delete', [JenisController::class, 'confirm']); // Menampilkan halaman konfirmasi untuk menghapus jenis berdasarkan ID
    Route::delete('/{id}/delete', [JenisController::class, 'delete']); // Menghapus jenis kendaraan berdasarkan ID
});

// Route Halaman data Mobil
Route::prefix('mobil')->group(function () {
    Route::get('/', [MobilController::class, 'index']); // Menampilkan daftar mobil
    Route::post('/list', [MobilController::class, 'list']); // Mengambil daftar mobil dalam format JSON (untuk DataTables)
    Route::get('/create', [MobilController::class, 'create']); // Menampilkan form untuk menambah mobil baru
    Route::post('/store', [MobilController::class, 'store']); // Menyimpan data mobil baru
    Route::get('/{id}/show', [MobilController::class, 'show']); // Menampilkan detail mobil berdasarkan ID
    Route::get('/{id}/edit', [MobilController::class, 'edit']); // Menampilkan form untuk mengedit data mobil
    Route::put('/{id}/update', [MobilController::class, 'update']); // Memperbarui data mobil berdasarkan ID
    Route::get('/{id}/delete', [MobilController::class, 'confirm']); // Menampilkan halaman konfirmasi untuk menghapus mobil berdasarkan ID
    Route::delete('/{id}/delete', [MobilController::class, 'delete']); // Menghapus data mobil berdasarkan ID
});
