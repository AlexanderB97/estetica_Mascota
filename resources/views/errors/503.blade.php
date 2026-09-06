<x-guest-layout>
    <div class="flex flex-col items-center justify-center py-12 text-center">
        <div class="bg-blue-100 rounded-full p-6 mb-6">
            <i class="fa-solid fa-screwdriver-wrench text-5xl text-blue-500"></i>
        </div>

        <h1 class="text-6xl font-bold text-blue-600 mb-2">503</h1>

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Servicio no disponible
        </h2>

        <p class="text-gray-500 max-w-sm mb-6">
            El sistema se encuentra temporalmente fuera de servicio.
            Intentá nuevamente en unos minutos.
        </p>

        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-full shadow transition flex items-center gap-2">
            <i class="fa-solid fa-rotate-right"></i>
            Intentar nuevamente
        </a>
    </div>
</x-guest-layout>

