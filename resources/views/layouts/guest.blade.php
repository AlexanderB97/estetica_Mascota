<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Estética Mascotas') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-10 bg-gradient-to-br from-purple-700 via-purple-500 to-pink-500">

            <!-- Marca -->
            <div class="mb-8 flex flex-col items-center text-white">
                <div class="w-20 h-20 rounded-full bg-white/15 backdrop-blur flex items-center justify-center shadow-lg ring-4 ring-white/20">
                    <i class="fa-solid fa-paw text-4xl"></i>
                </div>
                <h1 class="mt-4 text-2xl font-bold tracking-wide">Estética Mascotas</h1>
                <p class="text-sm text-white/80">Panel de administración</p>
            </div>

            <!-- Tarjeta -->
            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>

            <p class="mt-8 text-xs text-white/70">
                &copy; {{ date('Y') }} Estética Mascotas — Todos los derechos reservados
            </p>
        </div>
    </body>
</html>