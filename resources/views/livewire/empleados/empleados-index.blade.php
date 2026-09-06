<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-purple-700"><i class="fa-solid fa-id-badge mr-2"></i>Empleados</h1>
            <p class="text-gray-500 text-sm mt-1">Gestioná los empleados de la estética</p>
        </div>
        <button wire:click="abrirModal"
            class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-full shadow transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Nuevo Empleado
        </button>
    </div>

    @if (session()->has('mensaje'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4 flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> {{ session('mensaje') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-4 mb-4">
        <input wire:model.live="search" type="text" placeholder="🔍 Buscar empleado..."
            class="border border-gray-200 rounded-full px-5 py-2 w-full focus:outline-none focus:ring-2 focus:ring-purple-400" />
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="p-4 text-left">Nombre</th>
                    <th class="p-4 text-left">Legajo</th>
                    <th class="p-4 text-left">DNI</th>
                    <th class="p-4 text-left">Rol</th>
                    <th class="p-4 text-left">Estado</th>
                    <th class="p-4 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($empleados as $empleado)
                    <tr class="border-t hover:bg-purple-50 transition">
                        <td class="p-4 font-medium text-gray-800">
                            <i class="fa-solid fa-user text-purple-400 mr-1"></i>{{ $empleado->user->name }}
                            <p class="text-xs text-gray-400">{{ $empleado->user->email }}</p>
                        </td>
                        <td class="p-4 text-gray-600">{{ $empleado->legajo }}</td>
                        <td class="p-4 text-gray-600">{{ $empleado->dni }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($empleado->user->role == 'admin') bg-purple-100 text-purple-800
                                @else bg-blue-100 text-blue-800
                                @endif">
                                {{ ucfirst($empleado->user->role) }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($empleado->activo) bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $empleado->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="p-4 flex gap-2">
                            <button wire:click="editar({{ $empleado->id }})"
                                class="bg-amber-400 hover:bg-amber-500 text-white px-3 py-1 rounded-full text-xs transition">
                                <i class="fa-solid fa-pen"></i> Editar
                            </button>
                            <button wire:click="toggleActivo({{ $empleado->id }})"
                                class="@if($empleado->activo) bg-red-500 hover:bg-red-600 @else bg-green-500 hover:bg-green-600 @endif text-white px-3 py-1 rounded-full text-xs transition">
                                @if($empleado->activo)
                                    <i class="fa-solid fa-ban"></i> Dar de baja
                                @else
                                    <i class="fa-solid fa-check"></i> Activar
                                @endif
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">
                            <i class="fa-solid fa-id-badge text-4xl mb-2 block"></i>
                            No hay empleados cargados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $empleados->links() }}
    </div>

    @if ($modal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl">
                <h2 class="text-xl font-bold text-purple-700 mb-4">
                    <i class="fa-solid fa-id-badge mr-2"></i>
                    @if($empleadoId) Editar Empleado @else Nuevo Empleado @endif
                </h2>

                <p class="text-xs text-gray-500 mb-3 font-semibold uppercase">Datos de acceso</p>

                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nombre</label>
                        <input wire:model="name" type="text"
                            class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Rol</label>
                        <select wire:model="role"
                            class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400">
                            <option value="vendedor">Vendedor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="block text-sm text-gray-600 mb-1">Email</label>
                    <input wire:model="email" type="email"
                        class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                @if(!$empleadoId)
                    <div class="mb-3">
                        <label class="block text-sm text-gray-600 mb-1">Contraseña</label>
                        <input wire:model="password" type="password"
                            class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                @endif

                <p class="text-xs text-gray-500 mb-3 font-semibold uppercase mt-4">Datos del empleado</p>

                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Legajo</label>
                        <input wire:model="legajo" type="text"
                            class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                        @error('legajo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">DNI</label>
                        <input wire:model="dni" type="text"
                            class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                        @error('dni') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Teléfono</label>
                        <input wire:model="telefono" type="text"
                            class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Fecha de ingreso</label>
                        <input wire:model="fecha_ingreso" type="date"
                            class="border border-gray-200 rounded-lg w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-400" />
                        @error('fecha_ingreso') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Dirección</label>
                    <input wire:model="direccion" type="text"
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