<aside class="w-64 bg-gradient-to-b from-purple-800 to-purple-600 h-screen flex flex-col shadow-xl fixed top-0 left-0 z-50">

    <div class="px-6 py-3 border-b border-purple-500 shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-white">
            <div class="bg-white bg-opacity-20 rounded-full p-2">
                <i class="fa-solid fa-paw text-xl"></i>
            </div>
            <div>
                <p class="font-bold text-base leading-tight">Estética</p>
                <p class="font-bold text-base leading-tight">Mascotas</p>
            </div>
        </a>
    </div>

    <div class="px-6 py-2 border-b border-purple-500 shrink-0">
        <p class="text-purple-200 text-xs uppercase font-semibold mb-1">Usuario</p>
        <p class="text-white font-semibold text-sm">{{ auth()->user()->name }}</p>
        <span class="text-xs px-2 py-0.5 rounded-full mt-1 inline-block
            {{ auth()->user()->role === 'admin' ? 'bg-yellow-400 text-yellow-900' : 'bg-purple-400 text-white' }}">
            {{ ucfirst(auth()->user()->role) }}
        </span>
    </div>

    <nav class="flex-1 px-4 py-2 overflow-y-auto">

        <p class="text-purple-300 text-xs uppercase font-semibold mb-1 px-2">Principal</p>

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('dashboard') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-gauge w-4"></i>
            <span class="text-sm">Dashboard</span>
        </a>

        <p class="text-purple-300 text-xs uppercase font-semibold mb-1 px-2 mt-3">Gestión</p>

        <a href="{{ route('clientes.index') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('clientes.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-users w-4"></i>
            <span class="text-sm">Clientes</span>
        </a>

        <a href="{{ route('mascotas.index') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('mascotas.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-dog w-4"></i>
            <span class="text-sm">Mascotas</span>
        </a>

        <a href="{{ route('turnos.index') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('turnos.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-calendar w-4"></i>
            <span class="text-sm">Turnos</span>
        </a>

        <a href="{{ route('historial.index') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('historial.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-notes-medical w-4"></i>
            <span class="text-sm">Historial</span>
        </a>

        <p class="text-purple-300 text-xs uppercase font-semibold mb-1 px-2 mt-3">Ventas</p>

        <a href="{{ route('ventas.index') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('ventas.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-cash-register w-4"></i>
            <span class="text-sm">Ventas</span>
        </a>

        <a href="{{ route('caja.index') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('caja.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-vault w-4"></i>
            <span class="text-sm">Caja</span>
        </a>

        <a href="{{ route('productos.index') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('productos.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-box w-4"></i>
            <span class="text-sm">Productos</span>
        </a>

        <a href="{{ route('servicios.index') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('servicios.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-scissors w-4"></i>
            <span class="text-sm">Servicios</span>
        </a>

        <a href="{{ route('categorias.index') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('categorias.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-tags w-4"></i>
            <span class="text-sm">Categorías</span>
        </a>

        @can('admin')

        <p class="text-purple-300 text-xs uppercase font-semibold mb-1 px-2 mt-3">Administración</p>

        <a href="{{ route('proveedores.index') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('proveedores.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-truck w-4"></i>
            <span class="text-sm">Proveedores</span>
        </a>

        <a href="{{ route('compras.index') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('compras.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-cart-shopping w-4"></i>
            <span class="text-sm">Compras</span>
        </a>

        <a href="{{ route('stock.index') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('stock.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-warehouse w-4"></i>
            <span class="text-sm">Stock</span>
        </a>

        <a href="{{ route('empleados.index') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('empleados.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-id-badge w-4"></i>
            <span class="text-sm">Empleados</span>
        </a>

        <a href="{{ route('usuarios.index') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('usuarios.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-users-gear w-4"></i>
            <span class="text-sm">Usuarios</span>
        </a>

        <a href="{{ route('reportes.ventas') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5 {{ request()->routeIs('reportes.*') ? 'bg-white bg-opacity-20' : '' }}">
            <i class="fa-solid fa-chart-bar w-4"></i>
            <span class="text-sm">Reportes</span>
        </a>

        @endcan

    </nav>

    <div class="px-4 py-3 border-t border-purple-500 shrink-0">

        <a href="{{ route('profile') }}"
           class="flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-white hover:bg-opacity-20 transition mb-0.5">
            <i class="fa-solid fa-user w-4"></i>
            <span class="text-sm">Perfil</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-1.5 rounded-lg text-white hover:bg-red-500 hover:bg-opacity-50 transition">
                <i class="fa-solid fa-right-from-bracket w-4"></i>
                <span class="text-sm">Salir</span>
            </button>
        </form>

    </div>

</aside>