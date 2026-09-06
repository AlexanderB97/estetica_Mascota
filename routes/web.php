<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Actions\Logout;
use Illuminate\Http\Request;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified', 'empleado.activo'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard-main');
    })->name('dashboard');

    Route::get('/productos', \App\Livewire\Productos\ProductosIndex::class)->name('productos.index');
    Route::get('/servicios', \App\Livewire\Servicios\ServiciosIndex::class)->name('servicios.index');
    Route::get('/mascotas', \App\Livewire\Mascotas\MascotasIndex::class)->name('mascotas.index');
    Route::get('/turnos', \App\Livewire\Turnos\TurnosIndex::class)->name('turnos.index');
    Route::get('/ventas', \App\Livewire\Ventas\VentasIndex::class)->name('ventas.index');
    Route::get('/clientes', \App\Livewire\Clientes\ClientesIndex::class)->name('clientes.index');
    Route::get('/categorias', \App\Livewire\Categorias\CategoriasIndex::class)->name('categorias.index');
    Route::get('/proveedores', \App\Livewire\Proveedores\ProveedoresIndex::class)->name('proveedores.index');
    Route::get('/compras', \App\Livewire\Compras\ComprasIndex::class)->name('compras.index');
    Route::get('/empleados', \App\Livewire\Empleados\EmpleadosIndex::class)->name('empleados.index');
    Route::get('/stock', \App\Livewire\Stock\StockIndex::class)->name('stock.index');
    Route::get('/historial', \App\Livewire\Historial\HistorialIndex::class)->name('historial.index');
    Route::get('/usuarios', \App\Livewire\Usuarios\UsuariosIndex::class)->name('usuarios.index');
    Route::get('/reportes/ventas', \App\Livewire\Reportes\ReporteVentas::class)->name('reportes.ventas');
    Route::get('/caja', \App\Livewire\Caja\CajaIndex::class)->name('caja.index');
});


Route::post('/logout', function (Request $request, Logout $logout) {
    $logout();
    return redirect('/');
})->name('logout')->middleware('auth');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';

Route::get('/reset-opcache-temp-9x7', function () {
    if (function_exists('opcache_reset')) {
        opcache_reset();
        return 'OPcache reseteado correctamente';
    }
    return 'opcache_reset no está disponible en este servidor';
});

