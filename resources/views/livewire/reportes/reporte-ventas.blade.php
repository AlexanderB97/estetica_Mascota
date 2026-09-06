<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-purple-700"><i class="fa-solid fa-chart-bar mr-2"></i>Reporte de Ventas</h1>
        <p class="text-gray-500 text-sm mt-1">Ventas por empleado en un rango de fechas</p>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Desde</label>
                <input wire:model.live="desde" type="date"
                    class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Hasta</label>
                <input wire:model.live="hasta" type="date"
                    class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Empleado</label>
                <select wire:model.live="usuario_id"
                    class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <option value="">Todos los empleados</option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Resumen por empleado -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        @forelse($porEmpleado as $empleadoId => $datos)
            <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-purple-500">
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-purple-100 text-purple-600 rounded-full p-3">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">{{ $datos['nombre'] }}</p>
                        <p class="text-xs text-gray-500">{{ $datos['cantidad'] }} ventas</p>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-500">Completadas</p>
                        <p class="font-semibold text-green-600">{{ $datos['completadas'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Total</p>
                        <p class="text-xl font-bold text-purple-700">${{ number_format($datos['total'], 2) }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white rounded-2xl shadow p-8 text-center text-gray-400">
                <i class="fa-solid fa-chart-bar text-4xl mb-2 block"></i>
                No hay ventas en el período seleccionado.
            </div>
        @endforelse
    </div>

    <!-- Tabla detalle -->
    @if($ventas->count() > 0)
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div class="p-4 border-b">
                <h2 class="font-bold text-gray-700"><i class="fa-solid fa-list mr-2 text-purple-500"></i>Detalle de ventas</h2>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="p-4 text-left">#</th>
                        <th class="p-4 text-left">Empleado</th>
                        <th class="p-4 text-left">Total</th>
                        <th class="p-4 text-left">Estado</th>
                        <th class="p-4 text-left">Método pago</th>
                        <th class="p-4 text-left">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)
                        <tr class="border-t hover:bg-purple-50 transition">
                            <td class="p-4 text-gray-500">#{{ $venta->id }}</td>
                            <td class="p-4 font-medium text-gray-800">{{ $venta->usuario->name }}</td>
                            <td class="p-4 text-green-600 font-bold">${{ number_format($venta->total, 2) }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($venta->estado == 'pendiente') bg-yellow-100 text-yellow-800
                                    @elseif($venta->estado == 'completada') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($venta->estado) }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-600">{{ ucfirst($venta->metodo_pago) }}</td>
                            <td class="p-4 text-gray-500">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>