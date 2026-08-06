<?php

use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\BukuController;    
use Illuminate\Support\Facades\Route;

Route::controller(BukuController::class)->prefix('buku')->group(function () {
    Route::get('/', 'index');
    Route::get('/trash', 'trash'); 
    Route::post('/tambah', 'store');
    Route::get('/{id}', 'show');
    Route::patch('/{id}/toggle-aktif', 'toggleAktif');
    Route::delete('/{id}/delete', 'destroy');
    Route::put('/{id}/update', 'update');
    Route::post('/{id}/restore', 'restore');
    Route::delete('/{id}/force-delete', 'forceDelete');
});

Route::controller(PeminjamanController::class)->prefix('peminjaman')->group(function () {
    Route::post('/', 'store');
    Route::post('/{id}/kembalikan', 'kembalikan');
});