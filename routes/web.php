<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisController;

Route::get('/', [WelcomeController::class, 'index']);
Route::prefix('jenis')->group(function () {
    Route::get('/', [JenisController::class, 'index']);
    Route::get('/list', [JenisController::class, 'list']); // Menampilkan data
    Route::get('/create', [JenisController::class, 'create']); // Form tambah
    Route::post('/store', [JenisController::class, 'store']); // Menyimpan data
    Route::get('/{id}/edit', [JenisController::class, 'edit']); // Form edit
    Route::put('/{id}/update', [JenisController::class, 'update']); // Mengupdate data
    Route::get('/{id}/delete', [JenisController::class, 'confirm']); // Konfirmasi hapus
    Route::delete('/{id}/delete', [JenisController::class, 'delete']); // Menghapus data
});
