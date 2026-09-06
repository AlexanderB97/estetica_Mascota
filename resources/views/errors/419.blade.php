<x-guest-layout>
    <div class="flex flex-col items-center justify-center py-12 text-center">
        <div class="bg-amber-100 rounded-full p-6 mb-6">
            <i class="fa-solid fa-clock-rotate-left text-5xl text-amber-500"></i>
        </div>
        <h1 class="text-2xl font-bold text-amber-700 mb-2">Tu sesión expiró</h1>
        <p class="text-gray-500 max-w-sm mb-6">
            Por seguridad, cerramos tu sesión por inactividad. Volvé a iniciar sesión para continuar.
        </p>
        <a href="{{ route('login') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-full shadow transition flex items-center gap-2">
            <i class="fa-solid fa-right-to-bracket"></i> Iniciar sesión
        </a>
    </div>
</x-guest-layout>