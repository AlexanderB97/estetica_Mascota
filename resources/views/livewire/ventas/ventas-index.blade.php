<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-purple-700"><i class="fa-solid fa-cash-register mr-2"></i>Ventas</h1>
            <p class="text-gray-500 text-sm mt-1">Gestioná las ventas de la estética</p>
        </div>
        <button wire:click="abrirModal"
            class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-full shadow transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Nueva Venta
        </button>
    </div>

    @if (session()->has('mensaje'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4 flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> {{ session('mensaje') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="p-4 text-left">#</th>
                    <th class="p-4 text-left">Vendedor</th>
                    <th class="p-4 text-left">Total</th>
                    <th class="p-4 text-left">Estado</th>
                    <th class="p-4 text-left">Fecha</th>
                    <th class="p-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ventas as $venta)
                    <tr class="border-t hover:bg-purple-50 transition">
                        <td class="p-4 text-gray-500">#{{ $venta->id }}</td>
                        <td class="p-4 font-medium text-gray-800">
                            <i class="fa-solid fa-user text-gray-400 mr-1"></i>{{ $venta->usuario->name }}
                        </td>
                        <td class="p-4 text-green-600 font-bold text-base">${{ number_format($venta->total, 2) }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($venta->estado == 'pendiente') bg-yellow-100 text-yellow-800
                                @elseif($venta->estado == 'completada') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($venta->estado) }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-500">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                        <td class="p-4 flex gap-2">
                            <button wire:click="verDetalle({{ $venta->id }})"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-xs transition">
                                <i class="fa-solid fa-eye"></i> Ver
                            </button>
                            @if (auth()->user()->role === 'admin')
                                <button wire:click="eliminar({{ $venta->id }})"
                                    wire:confirm="Seguro que queres eliminar esta venta?"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-xs transition">
                                    <i class="fa-solid fa-trash"></i> Eliminar
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">
                            <i class="fa-solid fa-cash-register text-4xl mb-2 block"></i>
                            No hay ventas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $ventas->links() }}
    </div>

    @if ($modal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl">
                <h2 class="text-xl font-bold text-purple-700 mb-4">
                    <i class="fa-solid fa-cash-register mr-2"></i>Nueva Venta
                </h2>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Estado</label>
                    <select wire:model="estado"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <option value="pendiente">Pendiente</option>
                        <option value="completada">Completada</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 mb-4">
                    <p class="text-sm font-semibold text-gray-600 mb-3">Agregar productos</p>
                    <div class="flex gap-2">
                        <select wire:model="producto_id"
                            class="border border-gray-200 rounded-lg flex-1 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400">
                            <option value="">Seleccioná un producto</option>
                            @foreach ($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->nombre }} - ${{ number_format($producto->precio, 2) }}</option>
                            @endforeach
                        </select>
                        <input wire:model="cantidad" type="number" min="1"
                            class="border border-gray-200 rounded-lg w-20 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400" />
                        <button wire:click="agregarItem"
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

                @if(count($items) > 0)
                    <div class="mb-4">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 text-left">Producto</th>
                                    <th class="p-2 text-left">Cant.</th>
                                    <th class="p-2 text-left">Precio</th>
                                    <th class="p-2 text-left">Subtotal</th>
                                    <th class="p-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $i => $item)
                                    <tr class="border-t">
                                        <td class="p-2">{{ $item['nombre'] }}</td>
                                        <td class="p-2">{{ $item['cantidad'] }}</td>
                                        <td class="p-2">${{ number_format($item['precio'], 2) }}</td>
                                        <td class="p-2 text-green-600 font-semibold">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                                        <td class="p-2">
                                            <button wire:click="quitarItem({{ $i }})"
                                                class="text-red-500 hover:text-red-700">
                                                <i class="fa-solid fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-right mt-2 text-lg font-bold text-purple-700">
                            Total: ${{ number_format($this->total, 2) }}
                        </div>
                    </div>
                @endif

                @error('items') <span class="text-red-500 text-xs">Agregá al menos un producto.</span> @enderror

                <div class="flex justify-end gap-2">
                    <button wire:click="$set('modal', false)"
                        class="px-5 py-2 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
                        Cancelar
                    </button>
                    <button wire:click="guardar"
                        class="px-5 py-2 rounded-full bg-purple-600 text-white hover:bg-purple-700 transition">
                        <i class="fa-solid fa-save mr-1"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($modalDetalle && $ventaDetalle)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl">
                <h2 class="text-xl font-bold text-purple-700 mb-4">
                    <i class="fa-solid fa-receipt mr-2"></i>Detalle Venta #{{ $ventaDetalle->id }}
                </h2>

                <div class="mb-3 text-sm text-gray-600">
                    <p><i class="fa-solid fa-user mr-1"></i> Vendedor: <strong>{{ $ventaDetalle->usuario->name }}</strong></p>
                    <p><i class="fa-solid fa-calendar mr-1"></i> Fecha: <strong>{{ $ventaDetalle->created_at->format('d/m/Y H:i') }}</strong></p>
                    <p><i class="fa-solid fa-tag mr-1"></i> Estado: <strong>{{ ucfirst($ventaDetalle->estado) }}</strong></p>
                </div>

                <table class="w-full text-sm mb-4">
                    <thead class="bg-purple-100">
                        <tr>
                            <th class="p-2 text-left">Producto</th>
                            <th class="p-2 text-left">Cant.</th>
                            <th class="p-2 text-left">Precio unit.</th>
                            <th class="p-2 text-left">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventaDetalle->items as $item)
                            <tr class="border-t">
                                <td class="p-2">{{ $item->producto->nombre }}</td>
                                <td class="p-2">{{ $item->cantidad }}</td>
                                <td class="p-2">${{ number_format($item->precio_unitario, 2) }}</td>
                                <td class="p-2 text-green-600 font-semibold">${{ number_format($item->precio_unitario * $item->cantidad, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right text-lg font-bold text-purple-700 mb-4">
                    Total: ${{ number_format($ventaDetalle->total, 2) }}
                </div>

                <div class="flex justify-end">
                    <button wire:click="$set('modalDetalle', false)"
                        class="px-5 py-2 rounded-full bg-purple-600 text-white hover:bg-purple-700 transition">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>