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

Route::get('/login', function () {
    // Si está logueado lo redirige a la pagina principal
    if (Session::has('user')) {
        return redirect()->route('entradas.index');
    }

    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    // Credenciales
    if ($email === 'admin@example.com' && $password === '123456') {
        Session::put('user', ['email' => $email]);
        return redirect()->route('entradas.index')->with('success', 'Inicio de sesión exitoso.');
    }

    return back()
        ->withErrors(['login_error' => 'Credenciales incorrectas'])
        ->withInput();
})->name('login.process');

Route::get('/logout', function () {
    Session::forget('user');
    return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
})->name('logout');

Route::middleware(function ($request, $next) {
    // Si NO hay sesión  mandar a login
    if (!Session::has('user') && !$request->is('login')) {
        return redirect()->route('login');
    }
    return $next($request);
})->group(function () {

    // Home → redirige a Entradas
    Route::get('/', function () {
        return redirect()->route('entradas.index');
    })->name('home');
