<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::controller(BukuController::class)->prefix('buku')->name('buku.')->group(function () {
        Route::get('/', 'index');                  
        Route::post('/', 'store');                 
        Route::get('/trash', 'trash');           
        Route::get('/{id}', 'show');               
        Route::put('/{id}', 'update');            
        Route::delete('/{id}', 'destroy');       
        Route::patch('/{id}/toggle-aktif', 'toggleAktif'); 
        Route::post('/{id}/restore', 'restore');               
        Route::delete('/{id}/force-delete', 'forceDelete');
    });

Route::controller(PeminjamanController::class)->prefix('peminjaman')->name('peminjaman.')->group(function () {                        
        Route::post('/', 'store');                          
        Route::patch('/{id}', 'kembalikan');
    });
});

