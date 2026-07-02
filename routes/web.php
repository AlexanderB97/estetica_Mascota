<?php

use App\Livewire\Mascotas\MascotasIndex;
use App\Livewire\Productos\ProductosIndex;
use App\Livewire\Servicios\ServiciosIndex;
use App\Livewire\Turnos\TurnosIndex;
use App\Livewire\Ventas\VentasIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/productos', ProductosIndex::class)->name('productos.index');
    Route::get('/servicios', ServiciosIndex::class)->name('servicios.index');
    Route::get('/mascotas', MascotasIndex::class)->name('mascotas.index');
    Route::get('/turnos', TurnosIndex::class)->name('turnos.index');
    Route::get('/ventas', VentasIndex::class)->name('ventas.index');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
