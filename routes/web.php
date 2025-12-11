<?php

use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

// Ruta raíz: redirige al login si no está autenticado
Route::get('/', function () {
    return redirect()->route('login');
});

// =================== RUTAS DE AUTENTICACIÓN (Jetstream) ===================
Route::middleware(['auth', 'verified'])->group(function () {

    // Cambia el dashboard para que vaya directo a la lista de países
    Route::get('/dashboard', function () {
        return redirect()->route('countries.index');
    })->name('dashboard');

    // Descargar PDF
    Route::get('/countries/export/pdf', [CountryController::class, 'pdf'])
        ->name('countries.pdf');

    // CRUD de países
    Route::resource('countries', CountryController::class);

    Route::get('/countries/create', \App\Livewire\CountryCreate::class)->name('countries.create');
    Route::get('/countries/{country}/edit', \App\Livewire\CountryEdit::class)->name('countries.edit');

});

// Las rutas de login, registro, forgot-password, etc. las genera Jetstream automáticamente
// NO necesitas incluir ningún jetstream.php