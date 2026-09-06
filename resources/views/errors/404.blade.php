<x-guest-layout>
    <div class="flex flex-col items-center justify-center py-12 text-center">
        <div class="bg-purple-100 rounded-full p-6 mb-6">
            <i class="fa-solid fa-magnifying-glass text-5xl text-purple-500"></i>
        </div>

        <h1 class="text-6xl font-bold text-purple-700 mb-2">404</h1>

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Página no encontrada
        </h2>

        <p class="text-gray-500 max-w-sm mb-6">
            La página que estás buscando no existe o fue movida.
        </p>

        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-full shadow transition flex items-center gap-2">
            <i class="fa-solid fa-house"></i>
            Volver al inicio
        </a>
    </div>
</x-guest-layout>