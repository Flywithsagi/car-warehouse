<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\MobilController;

// Route Halaman Dashboard
Route::get('/', [WelcomeController::class, 'index']);

// Route Halaman Jenis
Route::prefix('jenis')->group(function () {
    Route::get('/', [JenisController::class, 'index']);
    Route::post('/list', [JenisController::class, 'list']);
    Route::get('/create', [JenisController::class, 'create']);
    Route::post('/store', [JenisController::class, 'store']);
    Route::get('/{id}/show', [JenisController::class, 'show']);
    Route::get('/{id}/edit', [JenisController::class, 'edit']);
    Route::put('/{id}/update', [JenisController::class, 'update']);
    Route::get('/{id}/delete', [JenisController::class, 'confirm']);
    Route::delete('/{id}/delete', [JenisController::class, 'delete']);
});

// Route Halaman data Mobil
Route::prefix('mobil')->group(function () {
    Route::get('/', [MobilController::class, 'index']);
    Route::post('/list', [MobilController::class, 'list']);
    Route::get('/create', [MobilController::class, 'create']);
    Route::post('/store', [MobilController::class, 'store']);
    Route::get('/{id}/show', [MobilController::class, 'show']);
    Route::get('/{id}/edit', [MobilController::class, 'edit']);
    Route::put('/{id}/update', [MobilController::class, 'update']);
    Route::get('/{id}/delete', [MobilController::class, 'confirm']);
    Route::delete('/{id}/delete', [MobilController::class, 'delete']);
});