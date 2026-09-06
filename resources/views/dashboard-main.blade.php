<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estética Mascotas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-gray-100 min-h-screen font-sans">
<div class="flex min-h-screen">

    @include('components.sidebar')

    <div class="flex-1 ml-64 p-8">

        <div class="bg-gradient-to-r from-purple-600 to-purple-400 rounded-3xl p-8 mb-8 text-white shadow-xl">
            <div class="flex items-center gap-4">
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fa-solid fa-paw text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold">¡Bienvenido, {{ auth()->user()->name }}!</h1>
                    <p class="text-purple-100 mt-1">Panel de control — Estética Mascotas</p>
                </div>
            </div>
        </div>

        <h2 class="text-lg font-bold text-gray-600 mb-4 uppercase tracking-wide">Accesos rápidos</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

            <a href="{{ route('clientes.index') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-indigo-100 text-indigo-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-users"></i>
                </div>
                <span class="font-semibold text-gray-700">Clientes</span>
            </a>

            <a href="{{ route('mascotas.index') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-blue-100 text-blue-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-dog"></i>
                </div>
                <span class="font-semibold text-gray-700">Mascotas</span>
            </a>

            <a href="{{ route('turnos.index') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-green-100 text-green-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-calendar"></i>
                </div>
                <span class="font-semibold text-gray-700">Turnos</span>
            </a>

            <a href="{{ route('historial.index') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-teal-100 text-teal-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-notes-medical"></i>
                </div>
                <span class="font-semibold text-gray-700">Historial</span>
            </a>

            <a href="{{ route('ventas.index') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-amber-100 text-amber-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-cash-register"></i>
                </div>
                <span class="font-semibold text-gray-700">Ventas</span>
            </a>

            <a href="{{ route('caja.index') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-yellow-100 text-yellow-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-vault"></i>
                </div>
                <span class="font-semibold text-gray-700">Caja</span>
            </a>

            <a href="{{ route('productos.index') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-purple-100 text-purple-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-box"></i>
                </div>
                <span class="font-semibold text-gray-700">Productos</span>
            </a>

            <a href="{{ route('servicios.index') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-rose-100 text-rose-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-scissors"></i>
                </div>
                <span class="font-semibold text-gray-700">Servicios</span>
            </a>

            <a href="{{ route('categorias.index') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-pink-100 text-pink-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-tags"></i>
                </div>
                <span class="font-semibold text-gray-700">Categorías</span>
            </a>

            @can('admin')

            <a href="{{ route('proveedores.index') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-teal-100 text-teal-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-truck"></i>
                </div>
                <span class="font-semibold text-gray-700">Proveedores</span>
            </a>

            <a href="{{ route('compras.index') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-cyan-100 text-cyan-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <span class="font-semibold text-gray-700">Compras</span>
            </a>

            <a href="{{ route('stock.index') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-orange-100 text-orange-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-warehouse"></i>
                </div>
                <span class="font-semibold text-gray-700">Stock</span>
            </a>

            <a href="{{ route('empleados.index') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-violet-100 text-violet-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-id-badge"></i>
                </div>
                <span class="font-semibold text-gray-700">Empleados</span>
            </a>

            <a href="{{ route('usuarios.index') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-yellow-100 text-yellow-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
                <span class="font-semibold text-gray-700">Usuarios</span>
            </a>

            <a href="{{ route('reportes.ventas') }}" class="bg-white rounded-2xl shadow p-6 flex flex-col items-center gap-3 hover:shadow-lg hover:bg-purple-50 transition group">
                <div class="bg-indigo-100 text-indigo-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-chart-bar"></i>
                </div>
                <span class="font-semibold text-gray-700">Reportes</span>
            </a>

            @endcan

        </div>
    </div>
</div>

@livewireScripts
</body>
</html>