<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-purple-700"><i class="fa-solid fa-calendar mr-2"></i>Turnos</h1>
            <p class="text-gray-500 text-sm mt-1">Gestioná los turnos de la estética</p>
        </div>
        <button wire:click="abrirModal"
            class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-full shadow transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Nuevo Turno
        </button>
    </div>

    @if (session()->has('mensaje'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4 flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> {{ session('mensaje') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-4 mb-4">
        <input wire:model.live="search" type="text" placeholder="🔍 Buscar por mascota o servicio..."
            class="border border-gray-200 rounded-full px-5 py-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-400" />
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="p-4 text-left">Mascota</th>
                    <th class="p-4 text-left">Servicio</th>
                    <th class="p-4 text-left">Empleado</th>
                    <th class="p-4 text-left">Fecha y hora</th>
                    <th class="p-4 text-left">Estado</th>
                    <th class="p-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($turnos as $turno)
                    <tr class="border-t hover:bg-purple-50 transition">
                        <td class="p-4 font-medium text-gray-800">
                            <i class="fa-solid fa-paw text-purple-400 mr-1"></i>{{ $turno->mascota->nombre }}
                        </td>
                        <td class="p-4 text-gray-700">{{ $turno->servicio->nombre }}</td>
                        <td class="p-4 text-gray-700">
                            <i class="fa-solid fa-user text-gray-400 mr-1"></i>{{ $turno->usuario->name }}
                        </td>
                        <td class="p-4 text-gray-700">
                            <i class="fa-solid fa-clock text-gray-400 mr-1"></i>
                            {{ \Carbon\Carbon::parse($turno->fecha_hora)->format('d/m/Y H:i') }}
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($turno->estado == 'pendiente') bg-yellow-100 text-yellow-800
                                @elseif($turno->estado == 'confirmado') bg-blue-100 text-blue-800
                                @elseif($turno->estado == 'completado') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($turno->estado) }}
                            </span>
                        </td>
                        <td class="p-4 flex gap-2">
                            <button wire:click="editar({{ $turno->id }})"
                                class="bg-amber-400 hover:bg-amber-500 text-white px-3 py-1 rounded-full text-xs transition">
                                <i class="fa-solid fa-pen"></i> Editar
                            </button>
                            <button wire:click="eliminar({{ $turno->id }})"
                                wire:confirm="Seguro que queres eliminar este turno?"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-xs transition">
                                <i class="fa-solid fa-trash"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">
                            <i class="fa-solid fa-calendar-xmark text-4xl mb-2 block"></i>
                            No hay turnos cargados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $turnos->links() }}
    </div>

    @if ($modal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
                <h2 class="text-xl font-bold text-purple-700 mb-4">
                    <i class="fa-solid fa-calendar mr-2"></i>
                    @if($turnoId) Editar Turno @else Nuevo Turno @endif
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
                    <label class="block text-sm text-gray-600 mb-1">Servicio</label>
                    <select wire:model="servicio_id"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <option value="">Seleccioná un servicio</option>
                        @foreach ($servicios as $servicio)
                            <option value="{{ $servicio->id }}">{{ $servicio->nombre }} - ${{ number_format($servicio->precio, 2) }}</option>
                        @endforeach
                    </select>
                    @error('servicio_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="block text-sm text-gray-600 mb-1">Empleado</label>
                    <select wire:model="usuario_id"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <option value="">Seleccioná un empleado</option>
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                        @endforeach
                    </select>
                    @error('usuario_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="block text-sm text-gray-600 mb-1">Fecha y hora</label>
                    <input wire:model="fecha_hora" type="datetime-local"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                    @error('fecha_hora') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="block text-sm text-gray-600 mb-1">Estado</label>
                    <select wire:model="estado"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <option value="pendiente">Pendiente</option>
                        <option value="confirmado">Confirmado</option>
                        <option value="completado">Completado</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Notas</label>
                    <textarea wire:model="notas" rows="3"
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