<div>
    @if (session()->has('mensaje'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('mensaje') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-2xl font-bold text-purple-700 flex items-center gap-2">
                🧾 Ventas
            </h1>
            <p class="text-gray-500 text-sm">Gestioná las ventas de la estética</p>
        </div>
        <button wire:click="abrirModal" class="bg-purple-600 text-white px-4 py-2 rounded-full hover:bg-purple-700">
            + Nueva Venta
        </button>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-purple-700 text-white">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Vendedor</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Estado</th>
                    <th class="p-3">Fecha</th>
                    <th class="p-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ventas as $venta)
                    <tr class="border-b">
                        <td class="p-3">{{ $venta->id }}</td>
                        <td class="p-3">{{ $venta->usuario->name ?? '—' }}</td>
                        <td class="p-3">${{ number_format($venta->total, 2) }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                                {{ ucfirst($venta->estado) }}
                            </span>
                        </td>
                        <td class="p-3">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                        <td class="p-3">
                            <button wire:click="eliminar({{ $venta->id }})"
                                    wire:confirm="¿Seguro que querés eliminar esta venta?"
                                    class="text-red-500 hover:text-red-700">
                                🗑️
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-400">No hay ventas registradas todavía.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-3">
            {{ $ventas->links() }}
        </div>
    </div>

    {{-- Modal Nueva Venta --}}
    @if ($modal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6">
                <h2 class="text-xl font-bold text-purple-700 flex items-center gap-2 mb-4">
                    🧾 Nueva Venta
                </h2>

                {{-- Cliente (opcional) --}}
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Cliente (opcional)</label>
                    <select wire:model="cliente_id" class="w-full border rounded-lg p-2">
                        <option value="">Sin cliente asociado</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Estado --}}
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Estado</label>
                    <select wire:model="estado" class="w-full border rounded-lg p-2">
                        <option value="pendiente">Pendiente</option>
                        <option value="completada">Completada</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                    @error('estado') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Método de pago --}}
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Método de pago</label>
                    <select wire:model="metodo_pago" class="w-full border rounded-lg p-2">
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="transferencia">Transferencia</option>
                    </select>
                </div>

                {{-- Agregar productos o servicio --}}
                <div class="mb-4 bg-gray-50 p-3 rounded-lg">
    <label class="block text-sm text-gray-600 mb-2">Agregar producto o servicio</label>
    <div class="flex gap-2">
        <select wire:model="item_seleccionado" class="flex-1 border rounded-lg p-2">
            <option value="">Seleccioná una opción</option>
            <optgroup label="Productos">
                @foreach ($productos as $producto)
                    <option value="producto-{{ $producto->id }}">
                        {{ $producto->nombre }} (stock: {{ $producto->stock }}) — ${{ number_format($producto->precio, 2) }}
                    </option>
                @endforeach
            </optgroup>
            <optgroup label="Servicios">
                @foreach ($servicios as $servicio)
                    <option value="servicio-{{ $servicio->id }}">
                        {{ $servicio->nombre }} ({{ $servicio->duracion_minutos }} min) — ${{ number_format($servicio->precio, 2) }}
                    </option>
                @endforeach
            </optgroup>
        </select>
        <input type="number" wire:model="cantidad" min="1" class="w-20 border rounded-lg p-2 text-center">
        <button wire:click="agregarItem" class="bg-purple-600 text-white w-10 h-10 rounded-lg hover:bg-purple-700">+</button>
    </div>
</div>

                {{-- Carrito temporal (items) --}}
                <div class="mb-4">
                    @if (empty($items))
                        <p class="text-gray-400 text-sm text-center py-4">Todavía no agregaste productos.</p>
                    @else
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-500 border-b">
                                    <th class="py-1">Producto</th>
                                    <th class="py-1 text-center">Cant.</th>
                                    <th class="py-1 text-right">Subtotal</th>
                                    <th class="py-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $index => $item)
                                    <tr class="border-b">
                                        <td class="py-2">{{ $item['nombre'] }}</td>
                                        <td class="py-2 text-center">{{ $item['cantidad'] }}</td>
                                        <td class="py-2 text-right">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                                        <td class="py-2 text-right">
                                            <button wire:click="quitarItem({{ $index }})"
                                                    class="text-red-500 hover:text-red-700">
                                                🗑️
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    @error('items') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Total --}}
                <div class="flex justify-between items-center mb-6 text-lg font-bold text-purple-700">
                    <span>Total</span>
                    <span>${{ number_format($this->total, 2) }}</span>
                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-2">
                    <button wire:click="$set('modal', false)" class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button wire:click="guardar" class="px-4 py-2 rounded-lg bg-purple-600 text-white hover:bg-purple-700">
                        💾 Guardar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>