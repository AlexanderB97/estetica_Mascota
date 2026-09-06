<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estética Mascotas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-gradient-to-r from-purple-700 to-purple-500 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
           <a href="{{ url('/') }}" class="flex items-center gap-2 text-white text-xl font-bold">
                <i class="fa-solid fa-paw"></i> Estética Mascotas
            </a>
            <div class="flex gap-4">
    <a href="{{ route('login') }}" class="bg-white text-purple-700 px-4 py-1 rounded-full text-sm font-semibold hover:bg-purple-100 transition">
        <i class="fa-solid fa-right-to-bracket mr-1"></i>Iniciar sesión
    </a>
</div>
        </div>
    </nav>

    <section class="max-w-7xl mx-auto px-4 py-20 flex flex-col items-center text-center">
        <div class="text-8xl mb-6">🐾</div>
        <h1 class="text-5xl font-bold text-purple-700 mb-4">Estética Mascotas</h1>
        <p class="text-gray-500 text-xl mb-8 max-w-xl">Sistema profesional de gestión de ventas, turnos e inventario para tu estética de mascotas.</p>
        <div class="flex gap-4">
     <a href="{{ route('login') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-full text-lg font-semibold shadow transition">
        <i class="fa-solid fa-right-to-bracket mr-2"></i>Iniciar sesión
    </a>
</div>
    </section>

    <section class="max-w-7xl mx-auto px-4 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow p-6 text-center">
                <div class="text-4xl text-purple-500 mb-3"><i class="fa-solid fa-calendar-check"></i></div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Gestión de Turnos</h3>
                <p class="text-gray-500 text-sm">Organizá los turnos de tus clientes de forma simple y eficiente.</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-6 text-center">
                <div class="text-4xl text-purple-500 mb-3"><i class="fa-solid fa-box"></i></div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Control de Inventario</h3>
                <p class="text-gray-500 text-sm">Mantenés el stock de productos actualizado en todo momento.</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-6 text-center">
                <div class="text-4xl text-purple-500 mb-3"><i class="fa-solid fa-cash-register"></i></div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Registro de Ventas</h3>
                <p class="text-gray-500 text-sm">Registrá y seguí todas las ventas de tu negocio fácilmente.</p>
            </div>
        </div>
    </section>

</body>
</html>