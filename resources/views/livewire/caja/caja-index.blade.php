<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-purple-700"><i class="fa-solid fa-cash-register mr-2"></i>Control de Caja</h1>
        <p class="text-gray-500 text-sm mt-1">Apertura y cierre de caja diario</p>
    </div>

    @if (session()->has('mensaje'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4 flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> {{ session('mensaje') }}
        </div>
    @endif

    @if (!$cajaAbierta)
        <!-- ABRIR CAJA -->
        <div class="bg-white rounded-2xl shadow p-8 max-w-md mx-auto text-center">
            <div class="bg-purple-100 text-purple-600 rounded-full p-6 text-4xl inline-block mb-4">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Caja cerrada</h2>
            <p class="text-gray-500 mb-6">Ingresá el monto inicial para abrir la caja</p>

            <div class="mb-4 text-left">
                <label class="block text-sm text-gray-600 mb-1">Monto inicial ($)</label>
                <input wire:model="monto_inicial" type="number" step="0.01" min="0"
                    class="border border-gray-200 rounded-lg w-full px-4 py-3 text-lg focus:outline-none focus:ring-2 focus:ring-purple-400" />
                @error('monto_inicial') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <button wire:click="abrirCaja"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-xl font-semibold text-lg transition">
                <i class="fa-solid fa-lock-open mr-2"></i>Abrir Caja
            </button>
        </div>

    @else
        <!-- CAJA ABIERTA -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

            <!-- Estado de caja -->
            <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-green-500">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-green-100 text-green-600 rounded-full p-3">
                        <i class="fa-solid fa-lock-open text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">Caja Abierta</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($cajaAbierta->abierto_at)->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-500">Monto inicial</p>
                    <p class="text-xl font-bold text-gray-800">${{ number_format($cajaAbierta->monto_inicial, 2) }}</p>
                </div>
            </div>

            <!-- Ventas del turno -->
            <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-purple-500">
                <p class="text-sm text-gray-500 mb-3 font-semibold">Ventas del turno</p>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600"><i class="fa-solid fa-money-bill mr-1 text-green-500"></i>Efectivo</span>
                        <span class="font-semibold">${{ number_format($this->totalEfectivo, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600"><i class="fa-solid fa-credit-card mr-1 text-blue-500"></i>Tarjeta</span>
                        <span class="font-semibold">${{ number_format($this->totalTarjeta, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600"><i class="fa-solid fa-mobile mr-1 text-purple-500"></i>Transferencia</span>
                        <span class="font-semibold">${{ number_format($this->totalTransferencia, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm border-t pt-2 mt-2">
                        <span class="font-bold text-gray-800">Total</span>
                        <span class="font-bold text-purple-700 text-lg">${{ number_format($this->totalVentas, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Cerrar caja -->
            <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-red-500">
                <p class="text-sm text-gray-500 mb-3 font-semibold">Cerrar caja</p>
                <div class="mb-3">
                    <label class="block text-sm text-gray-600 mb-1">Monto final contado ($)</label>
                    <input wire:model="monto_final" type="number" step="0.01" min="0"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                    @error('monto_final') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                @if($monto_final > 0)
                    <div class="mb-3 p-3 rounded-lg {{ ($monto_final - $cajaAbierta->monto_inicial - $this->totalEfectivo) >= 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                        <p class="text-xs font-semibold">Diferencia en efectivo:</p>
                        <p class="text-lg font-bold">
                            ${{ number_format($monto_final - $cajaAbierta->monto_inicial - $this->totalEfectivo, 2) }}
                        </p>
                    </div>
                @endif

                <button wire:click="cerrarCaja"
                    wire:confirm="Seguro que querés cerrar la caja?"
                    class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-xl font-semibold transition">
                    <i class="fa-solid fa-lock mr-2"></i>Cerrar Caja
                </button>
            </div>
        </div>

        <!-- Ventas del turno detalle -->
        @if($this->ventasDelTurno->count() > 0)
            <div class="bg-white rounded-2xl shadow overflow-hidden mb-6">
                <div class="p-4 border-b">
                    <h2 class="font-bold text-gray-700"><i class="fa-solid fa-list mr-2 text-purple-500"></i>Ventas de este turno</h2>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-purple-600 text-white">
                        <tr>
                            <th class="p-4 text-left">#</th>
                            <th class="p-4 text-left">Total</th>
                            <th class="p-4 text-left">Método pago</th>
                            <th class="p-4 text-left">Estado</th>
                            <th class="p-4 text-left">Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->ventasDelTurno as $venta)
                            <tr class="border-t hover:bg-purple-50 transition">
                                <td class="p-4 text-gray-500">#{{ $venta->id }}</td>
                                <td class="p-4 text-green-600 font-bold">${{ number_format($venta->total, 2) }}</td>
                                <td class="p-4 text-gray-600">{{ ucfirst($venta->metodo_pago) }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        @if($venta->estado == 'pendiente') bg-yellow-100 text-yellow-800
                                        @elseif($venta->estado == 'completada') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($venta->estado) }}
                                    </span>
                                </td>
                                <td class="p-4 text-gray-500">{{ $venta->created_at->format('H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif

    <!-- Historial de cierres -->
    @if($historial->count() > 0)
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div class="p-4 border-b">
                <h2 class="font-bold text-gray-700"><i class="fa-solid fa-clock-rotate-left mr-2 text-purple-500"></i>Historial de cierres</h2>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="p-4 text-left">Apertura</th>
                        <th class="p-4 text-left">Cierre</th>
                        <th class="p-4 text-left">Monto inicial</th>
                        <th class="p-4 text-left">Monto final</th>
                        <th class="p-4 text-left">Diferencia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historial as $cierre)
                        <tr class="border-t hover:bg-purple-50 transition">
                            <td class="p-4 text-gray-600">{{ \Carbon\Carbon::parse($cierre->abierto_at)->format('d/m/Y H:i') }}</td>
                            <td class="p-4 text-gray-600">{{ \Carbon\Carbon::parse($cierre->cerrado_at)->format('d/m/Y H:i') }}</td>
                            <td class="p-4 text-gray-800">${{ number_format($cierre->monto_inicial, 2) }}</td>
                            <td class="p-4 text-gray-800">${{ number_format($cierre->monto_final, 2) }}</td>
                            <td class="p-4 font-semibold {{ ($cierre->monto_final - $cierre->monto_inicial) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                ${{ number_format($cierre->monto_final - $cierre->monto_inicial, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>