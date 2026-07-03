<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-purple-700"><i class="fa-solid fa-dog mr-2"></i>Mascotas</h1>
            <p class="text-gray-500 text-sm mt-1">Gestioná las mascotas de los clientes</p>
        </div>
        <button wire:click="abrirModal"
            class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-full shadow transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Nueva Mascota
        </button>
    </div>

    @if (session()->has('mensaje'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4 flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> {{ session('mensaje') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-4 mb-4">
        <input wire:model.live="search" type="text" placeholder="🔍 Buscar mascota..."
            class="border border-gray-200 rounded-full px-5 py-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-400" />
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="p-4 text-left">Nombre</th>
                    <th class="p-4 text-left">Especie</th>
                    <th class="p-4 text-left">Raza</th>
                    <th class="p-4 text-left">Cliente</th>
                    <th class="p-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mascotas as $mascota)
                    <tr class="border-t hover:bg-purple-50 transition">
                        <td class="p-4 font-medium text-gray-800">
                            <i class="fa-solid fa-paw text-purple-400 mr-1"></i>{{ $mascota->nombre }}
                        </td>
                        <td class="p-4">
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">
                                {{ $mascota->especie }}
                            </span>
                        </td>
                        <td class="p-4 text-gray-500">{{ $mascota->raza ?? '-' }}</td>
                        <td class="p-4 text-gray-700">
                                 <i class="fa-solid fa-user text-gray-400 mr-1"></i>{{ $mascota->cliente->nombre }}
                        </td>
                        <td class="p-4 flex gap-2">
                            <button wire:click="editar({{ $mascota->id }})"
                                class="bg-amber-400 hover:bg-amber-500 text-white px-3 py-1 rounded-full text-xs transition">
                                <i class="fa-solid fa-pen"></i> Editar
                            </button>
                            <button wire:click="eliminar({{ $mascota->id }})"
                                wire:confirm="Seguro que queres eliminar esta mascota?"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-xs transition">
                                <i class="fa-solid fa-trash"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">
                            <i class="fa-solid fa-dog text-4xl mb-2 block"></i>
                            No hay mascotas cargadas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $mascotas->links() }}
    </div>

    @if ($modal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
                <h2 class="text-xl font-bold text-purple-700 mb-4">
                    <i class="fa-solid fa-dog mr-2"></i>
                    @if($mascotaId) Editar Mascota @else Nueva Mascota @endif
                </h2>

                <div class="mb-3">
                    <label class="block text-sm text-gray-600 mb-1">Cliente</label>
                    <select wire:model="cliente_id"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <option value="">Seleccioná un cliente</option>
                        @foreach ($clientes as $cliente)
                             <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                    @error('cliente_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="block text-sm text-gray-600 mb-1">Nombre</label>
                    <input wire:model="nombre" type="text"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                    @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Especie</label>
                        <input wire:model="especie" type="text"
                            class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                        @error('especie') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Raza</label>
                        <input wire:model="raza" type="text"
                            class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Fecha de nacimiento</label>
                    <input wire:model="fecha_nacimiento" type="date"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
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