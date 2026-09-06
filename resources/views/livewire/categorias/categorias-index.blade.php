<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-purple-700"><i class="fa-solid fa-tags mr-2"></i>Categorías</h1>
            <p class="text-gray-500 text-sm mt-1">Gestioná las categorías de productos</p>
        </div>
        <button wire:click="abrirModal"
            class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-full shadow transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Nueva Categoría
        </button>
    </div>

    @if (session()->has('mensaje'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4 flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> {{ session('mensaje') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-4 mb-4">
        <input wire:model.live="search" type="text" placeholder="🔍 Buscar categoría..."
            class="border border-gray-200 rounded-full px-5 py-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-400" />
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="p-4 text-left">Nombre</th>
                    <th class="p-4 text-left">Descripción</th>
                    <th class="p-4 text-left">Productos</th>
                    <th class="p-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categorias as $categoria)
                    <tr class="border-t hover:bg-purple-50 transition">
                        <td class="p-4 font-medium text-gray-800">
                            <i class="fa-solid fa-tag text-purple-400 mr-1"></i>{{ $categoria->nombre }}
                        </td>
                        <td class="p-4 text-gray-500">{{ $categoria->descripcion ?? '-' }}</td>
                        <td class="p-4">
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-medium">
                                {{ $categoria->productos->count() }} productos
                            </span>
                        </td>
                        <td class="p-4 flex gap-2">
                            <button wire:click="editar({{ $categoria->id }})"
                                class="bg-amber-400 hover:bg-amber-500 text-white px-3 py-1 rounded-full text-xs transition">
                                <i class="fa-solid fa-pen"></i> Editar
                            </button>
                            <button wire:click="eliminar({{ $categoria->id }})"
                                wire:confirm="Seguro que queres eliminar esta categoría?"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-xs transition">
                                <i class="fa-solid fa-trash"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-400">
                            <i class="fa-solid fa-tags text-4xl mb-2 block"></i>
                            No hay categorías cargadas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categorias->links() }}
    </div>

    @if ($modal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
                <h2 class="text-xl font-bold text-purple-700 mb-4">
                    <i class="fa-solid fa-tag mr-2"></i>
                    @if($categoriaId) Editar Categoría @else Nueva Categoría @endif
                </h2>

                <div class="mb-3">
                    <label class="block text-sm text-gray-600 mb-1">Nombre</label>
                    <input wire:model="nombre" type="text"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                    @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Descripción</label>
                    <textarea wire:model="descripcion" rows="3"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400"></textarea>
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