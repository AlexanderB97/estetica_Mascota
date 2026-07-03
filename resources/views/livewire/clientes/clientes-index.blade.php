<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-purple-700"><i class="fa-solid fa-address-book mr-2"></i>Clientes</h1>
            <p class="text-gray-500 text-sm mt-1">Gestioná los datos de contacto de tus clientes</p>
        </div>
        <button wire:click="abrirModal"
            class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-full shadow transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Nuevo Cliente
        </button>
    </div>

    @if (session()->has('mensaje'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4 flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> {{ session('mensaje') }}
        </div>
    @endif

    <div class="mb-4">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar cliente..."
            class="border border-gray-200 rounded-lg w-full max-w-sm px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400" />
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="p-4 text-left">Nombre</th>
                    <th class="p-4 text-left">Teléfono</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-left">Dirección</th>
                    <th class="p-4 text-left">Mascotas</th>
                    <th class="p-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clientes as $cliente)
                    <tr class="border-t hover:bg-purple-50 transition">
                        <td class="p-4 font-medium text-gray-800">
                            <i class="fa-solid fa-user text-gray-400 mr-1"></i>{{ $cliente->nombre }}
                        </td>
                        <td class="p-4 text-gray-600">{{ $cliente->telefono ?? '—' }}</td>
                        <td class="p-4 text-gray-600">{{ $cliente->email ?? '—' }}</td>
                        <td class="p-4 text-gray-600">{{ $cliente->direccion ?? '—' }}</td>
                        <td class="p-4 text-gray-600">{{ $cliente->mascotas()->count() }}</td>
                        <td class="p-4 flex gap-2">
                            <button wire:click="editar({{ $cliente->id }})"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-full text-xs transition">
                                <i class="fa-solid fa-pen"></i> Editar
                            </button>
                            @if (auth()->user()->role === 'admin')
                                <button wire:click="eliminar({{ $cliente->id }})"
                                    wire:confirm="Seguro que queres eliminar este cliente? Si tiene mascotas cargadas, tambien se eliminaran."
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-xs transition">
                                    <i class="fa-solid fa-trash"></i> Eliminar
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">
                            <i class="fa-solid fa-address-book text-4xl mb-2 block"></i>
                            No hay clientes cargados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $clientes->links() }}
    </div>

    @if ($modal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl">
                <h2 class="text-xl font-bold text-purple-700 mb-4">
                    <i class="fa-solid fa-address-book mr-2"></i>{{ $clienteId ? 'Editar Cliente' : 'Nuevo Cliente' }}
                </h2>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Nombre</label>
                    <input wire:model="nombre" type="text"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                    @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Teléfono</label>
                    <input wire:model="telefono" type="text"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                    @error('telefono') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Email</label>
                    <input wire:model="email" type="email"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Dirección</label>
                    <input wire:model="direccion" type="text"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                    @error('direccion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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