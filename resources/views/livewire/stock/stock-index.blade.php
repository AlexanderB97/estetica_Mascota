<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-purple-700"><i class="fa-solid fa-warehouse mr-2"></i>Control de Stock</h1>
            <p class="text-gray-500 text-sm mt-1">Registrá movimientos de inventario</p>
        </div>
        <button wire:click="abrirModal"
            class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-full shadow transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Nuevo Movimiento
        </button>
    </div>

    @if (session()->has('mensaje'))
    <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4 flex items-center gap-2">
        <i class="fa-solid fa-check-circle"></i> {{ session('mensaje') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-4 mb-4">
        <input wire:model.live="search" type="text" placeholder="🔍 Buscar producto..."
            class="border border-gray-200 rounded-full px-5 py-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-400" />
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="p-4 text-left">Producto</th>
                    <th class="p-4 text-left">Tipo</th>
                    <th class="p-4 text-left">Cantidad</th>
                    <th class="p-4 text-left">Motivo</th>
                    <th class="p-4 text-left">Usuario</th>
                    <th class="p-4 text-left">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($movimientos as $movimiento)
                <tr class="border-t hover:bg-purple-50 transition">
                    <td class="p-4 font-medium text-gray-800">
                        <i class="fa-solid fa-box text-purple-400 mr-1"></i>{{ $movimiento->producto->nombre }}
                    </td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($movimiento->tipo == 'entrada') bg-green-100 text-green-800
                                @elseif($movimiento->tipo == 'salida') bg-red-100 text-red-800
                                @else bg-blue-100 text-blue-800
                                @endif">
                            {{ ucfirst($movimiento->tipo) }}
                        </span>
                    </td>
                    <td class="p-4 font-semibold text-gray-800">{{ $movimiento->cantidad }}</td>
                    <td class="p-4 text-gray-500">{{ $movimiento->motivo ?? '-' }}</td>
                    <td class="p-4 text-gray-600">{{ $movimiento->usuario->name }}</td>
                    <td class="p-4 text-gray-500">{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-400">
                        <i class="fa-solid fa-warehouse text-4xl mb-2 block"></i>
                        No hay movimientos registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $movimientos->links() }}
    </div>

    @if ($modal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
            <h2 class="text-xl font-bold text-purple-700 mb-4">
                <i class="fa-solid fa-warehouse mr-2"></i>Nuevo Movimiento de Stock
            </h2>

            <div class="mb-3">
                <label class="block text-sm text-gray-600 mb-1">Producto</label>
                <select wire:model="producto_id"
                    class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <option value="">Seleccioná un producto</option>
                    @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }} (Stock: {{ $producto->stock }})</option>
                    @endforeach
                </select>
                @error('producto_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="block text-sm text-gray-600 mb-1">Tipo de movimiento</label>
                <select wire:model="tipo"
                    class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <option value="entrada">Entrada (suma stock)</option>
                    <option value="salida">Salida (resta stock)</option>
                    <option value="ajuste">Ajuste (establece stock)</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm text-gray-600 mb-1">Cantidad</label>
                <input wire:model="cantidad" type="number" min="1"
                    class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                @error('cantidad') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Motivo</label>
                <input wire:model="motivo" type="text"
                    class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400"
                    placeholder="Ej: Compra a proveedor, rotura, etc." />
            </div>

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
</div>