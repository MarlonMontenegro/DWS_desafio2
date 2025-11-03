<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\ReporteBalanceController;

Route::get('/', fn() => view('welcome'));

// Entradas
Route::get('/entradas', [EntradaController::class, 'index'])->name('entradas.index');
Route::get('/entradas/create', [EntradaController::class, 'create'])->name('entradas.create');
Route::post('/entradas', [EntradaController::class, 'store'])->name('entradas.store');

// Salidas
Route::get('/salidas', [SalidaController::class, 'index'])->name('salidas.index');
Route::get('/salidas/create', [SalidaController::class, 'create'])->name('salidas.create');
Route::post('/salidas', [SalidaController::class, 'store'])->name('salidas.store');

// Balance
Route::get('/balance', [ReporteBalanceController::class, 'index'])->name('balance.index');
Route::get('/balance/pdf', [ReporteBalanceController::class, 'pdf'])->name('balance.pdf');
