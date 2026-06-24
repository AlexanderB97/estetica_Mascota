<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-purple-700"><i class="fa-solid fa-gauge mr-2"></i>Panel Principal</h1>
            <p class="text-gray-500 text-sm mt-1">Resumen general del sistema</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow p-6 flex items-center gap-4">
                <div class="bg-purple-100 text-purple-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-box"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Productos</p>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Producto::count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6 flex items-center gap-4">
                <div class="bg-blue-100 text-blue-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-dog"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Mascotas</p>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Mascota::count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6 flex items-center gap-4">
                <div class="bg-green-100 text-green-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-calendar"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Turnos hoy</p>
                    <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Turno::whereDate('fecha_hora', today())->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6 flex items-center gap-4">
                <div class="bg-amber-100 text-amber-600 rounded-full p-4 text-2xl">
                    <i class="fa-solid fa-cash-register"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Ventas totales</p>
                    <p class="text-3xl font-bold text-gray-800">${{ number_format(\App\Models\Venta::where('estado', 'completada')->sum('total'), 0) }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-lg font-bold text-gray-700 mb-4"><i class="fa-solid fa-calendar-check mr-2 text-purple-500"></i>Próximos turnos</h2>
                @php $turnos = \App\Models\Turno::with(['mascota', 'servicio'])->where('fecha_hora', '>=', now())->orderBy('fecha_hora')->take(5)->get(); @endphp
                @forelse($turnos as $turno)
                    <div class="flex justify-between items-center border-b py-3">
                        <div>
                            <p class="font-medium text-gray-800"><i class="fa-solid fa-paw text-purple-400 mr-1"></i>{{ $turno->mascota->nombre }}</p>
                            <p class="text-sm text-gray-500">{{ $turno->servicio->nombre }}</p>
                        </div>
                        <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($turno->fecha_hora)->format('d/m H:i') }}</span>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">No hay turnos próximos.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-lg font-bold text-gray-700 mb-4"><i class="fa-solid fa-receipt mr-2 text-green-500"></i>Últimas ventas</h2>
                @php $ventas = \App\Models\Venta::with('usuario')->latest()->take(5)->get(); @endphp
                @forelse($ventas as $venta)
                    <div class="flex justify-between items-center border-b py-3">
                        <div>
                            <p class="font-medium text-gray-800">#{{ $venta->id }} - {{ $venta->usuario->name }}</p>
                            <p class="text-sm text-gray-500">{{ $venta->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <span class="text-green-600 font-bold">${{ number_format($venta->total, 2) }}</span>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">No hay ventas registradas.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>