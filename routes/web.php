<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\ReporteBalanceController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| Authenticated & Verified Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Entradas CRUD
    Route::resource('entradas', EntradaController::class)->except(['show']);

    // Salidas CRUD
    Route::resource('salidas', SalidaController::class)->except(['show']);

    // Balance Report (visualización y descarga PDF)
    Route::get('/balance', [ReporteBalanceController::class, 'index'])->name('balance.index');
    Route::get('/balance/pdf', [ReporteBalanceController::class, 'pdf'])->name('balance.pdf');
});

/*
|--------------------------------------------------------------------------
| Auth Scaffolding (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
