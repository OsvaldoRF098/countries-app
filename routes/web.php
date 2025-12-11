<?php

use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Http\Controllers\Livewire\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Healthcheck para Railway
Route::get('/up', function () {
    return response('OK', 200);
});

// Ruta raíz
Route::get('/', fn() => redirect()->route('login'));

// ---------------------------------------------------------------------
// RUTAS PÚBLICAS (sin autenticación)
// ---------------------------------------------------------------------

// Login de emergencia (entras directo sin pedir contraseña)
Route::get('/login-admin', function () {
    Auth::loginUsingId(1); // Usuario ID 1 (el que ya creaste)
    return redirect('/countries');
})->name('login.admin');

// Si quieres tener el formulario normal de login (opcional)
Route::get('/login-normal', function () {
    return view('auth.login'); // si tienes una vista personalizada
});

// Registro manual (funciona aunque Jetstream esté capado)
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// ---------------------------------------------------------------------
// RUTAS PROTEGIDAS (necesitan login)
// ---------------------------------------------------------------------

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard → directo a países
    Route::get('/dashboard', fn() => redirect()->route('countries.index'))->name('dashboard');

    // PDF
    Route::get('/countries/export/pdf', [CountryController::class, 'pdf'])
        ->name('countries.pdf');

    // CRUD de países
    Route::resource('countries', CountryController::class)->except(['create', 'edit']);

    // Create y Edit con Livewire
    Route::get('/countries/create', \App\Livewire\CountryCreate::class)->name('countries.create');
    Route::get('/countries/{country}/edit', \App\Livewire\CountryEdit::class)->name('countries.edit');
});