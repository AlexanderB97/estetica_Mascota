<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estética Mascotas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/dashboard" class="text-xl font-bold text-blue-600">🐾 Estética Mascotas</a>
            <div class="flex gap-4 text-sm">
                <a href="/productos" class="text-gray-600 hover:text-blue-600">Productos</a>
                <a href="/profile" class="text-gray-600 hover:text-blue-600">Perfil</a>
                <form method="POST" action="/logout">
                    @csrf
                    <button class="text-gray-600 hover:text-red-600">Salir</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>