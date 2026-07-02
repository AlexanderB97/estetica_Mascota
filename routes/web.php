<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/productos', \App\Livewire\Productos\ProductosIndex::class)->name('productos.index');
    Route::get('/servicios', \App\Livewire\Servicios\ServiciosIndex::class)->name('servicios.index');
    Route::get('/mascotas', \App\Livewire\Mascotas\MascotasIndex::class)->name('mascotas.index');
    Route::get('/turnos', \App\Livewire\Turnos\TurnosIndex::class)->name('turnos.index');
    Route::get('/ventas', \App\Livewire\Ventas\VentasIndex::class)->name('ventas.index');
    Route::get('/usuarios', \App\Livewire\Usuarios\UsuariosIndex::class)->name('usuarios.index');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/logout', function (\App\Livewire\Actions\Logout $logout) {
    $logout();

    return redirect('/');
})->name('logout');

require __DIR__.'/auth.php';