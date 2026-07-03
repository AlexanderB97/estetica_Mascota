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
<body class="bg-gray-50 min-h-screen font-sans">

    <nav class="bg-gradient-to-r from-purple-700 to-purple-500 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/dashboard" class="flex items-center gap-2 text-white text-xl font-bold">
                <i class="fa-solid fa-paw"></i>
                Estética Mascotas
            </a>
            <div class="flex gap-6 text-sm text-white">
                <a href="/productos" class="hover:text-purple-200 transition"><i class="fa-solid fa-box mr-1"></i>Productos</a>
                <a href="/servicios" class="hover:text-purple-200 transition"><i class="fa-solid fa-scissors mr-1"></i>Servicios</a>
                <a href="/mascotas" class="hover:text-purple-200 transition"><i class="fa-solid fa-dog mr-1"></i>Mascotas</a>
                <a href="/clientes" class="hover:text-purple-200 transition"><i class="fa-solid fa-address-book mr-1"></i>Clientes</a>
                <a href="/turnos" class="hover:text-purple-200 transition"><i class="fa-solid fa-calendar mr-1"></i>Turnos</a>
                <a href="/ventas" class="hover:text-purple-200 transition"><i class="fa-solid fa-cash-register mr-1"></i>Ventas</a>
                @if (auth()->user()->role === 'admin')
                <a href="/usuarios" class="hover:text-purple-200 transition"><i class="fa-solid fa-users-gear mr-1"></i>Usuarios</a>
                @endif
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button class="hover:text-red-300 transition"><i class="fa-solid fa-right-from-bracket mr-1"></i>Salir</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-6">
        {{ $slot }}
    </main>

    <footer class="bg-white border-t mt-10 py-4 text-center text-sm text-gray-500">
        © {{ date('Y') }} Estética Mascotas — Todos los derechos reservados
    </footer>

    @livewireScripts
</body>
</html>