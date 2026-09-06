<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-purple-700"><i class="fa-solid fa-notes-medical mr-2"></i>Historial Clínico</h1>
            <p class="text-gray-500 text-sm mt-1">Registros médicos de las mascotas</p>
        </div>
        <button wire:click="abrirModal"
            class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-full shadow transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Nuevo Registro
        </button>
    </div>

    @if (session()->has('mensaje'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4 flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> {{ session('mensaje') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-4 mb-4">
        <input wire:model.live="search" type="text" placeholder="🔍 Buscar por mascota..."
            class="border border-gray-200 rounded-full px-5 py-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-400" />
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="p-4 text-left">Mascota</th>
                    <th class="p-4 text-left">Turno</th>
                    <th class="p-4 text-left">Observaciones</th>
                    <th class="p-4 text-left">Fecha</th>
                    <th class="p-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($historiales as $historial)
                    <tr class="border-t hover:bg-purple-50 transition">
                        <td class="p-4 font-medium text-gray-800">
                            <i class="fa-solid fa-paw text-purple-400 mr-1"></i>{{ $historial->mascota->nombre }}
                        </td>
                        <td class="p-4 text-gray-600">
                            @if($historial->turno)
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
                                    {{ \Carbon\Carbon::parse($historial->turno->fecha_hora)->format('d/m/Y') }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="p-4 text-gray-700 max-w-xs truncate">{{ $historial->observaciones }}</td>
                        <td class="p-4 text-gray-500">{{ $historial->created_at->format('d/m/Y H:i') }}</td>
                        <td class="p-4 flex gap-2">
                            <button wire:click="editar({{ $historial->id }})"
                                class="bg-amber-400 hover:bg-amber-500 text-white px-3 py-1 rounded-full text-xs transition">
                                <i class="fa-solid fa-pen"></i> Editar
                            </button>
                            <button wire:click="eliminar({{ $historial->id }})"
                                wire:confirm="Seguro que queres eliminar este registro?"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-xs transition">
                                <i class="fa-solid fa-trash"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">
                            <i class="fa-solid fa-notes-medical text-4xl mb-2 block"></i>
                            No hay registros en el historial.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $historiales->links() }}
    </div>

    @if ($modal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
                <h2 class="text-xl font-bold text-purple-700 mb-4">
                    <i class="fa-solid fa-notes-medical mr-2"></i>
                    @if($historialId) Editar Registro @else Nuevo Registro @endif
                </h2>

                <div class="mb-3">
                    <label class="block text-sm text-gray-600 mb-1">Mascota</label>
                    <select wire:model="mascota_id"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <option value="">Seleccioná una mascota</option>
                        @foreach ($mascotas as $mascota)
                            <option value="{{ $mascota->id }}">{{ $mascota->nombre }} ({{ $mascota->especie }})</option>
                        @endforeach
                    </select>
                    @error('mascota_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="block text-sm text-gray-600 mb-1">Turno relacionado (opcional)</label>
                    <select wire:model="turno_id"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <option value="">Sin turno asociado</option>
                        @foreach ($turnos as $turno)
                            <option value="{{ $turno->id }}">
                                #{{ $turno->id }} - {{ $turno->mascota->nombre }} - {{ \Carbon\Carbon::parse($turno->fecha_hora)->format('d/m/Y H:i') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Observaciones</label>
                    <textarea wire:model="observaciones" rows="4"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400"
                        placeholder="Describí el estado de salud, tratamiento, notas importantes..."></textarea>
                    @error('observaciones') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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