<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisController;

Route::get('/', [WelcomeController::class, 'index']);

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
