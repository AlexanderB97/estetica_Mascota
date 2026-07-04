<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-gradient-to-r from-purple-700 to-purple-500 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" wire:navigate class="text-white font-bold text-lg flex items-center gap-2 mr-6">
                    <i class="fa-solid fa-paw"></i> Estética Mascotas
                </a>
                <div class="hidden space-x-4 sm:flex items-center">
                    <a href="{{ route('clientes.index') }}" class="text-white text-xs hover:text-purple-200 transition">
                        <i class="fa-solid fa-users mr-1"></i>Clientes
                    </a>
                    <a href="{{ route('mascotas.index') }}" class="text-white text-xs hover:text-purple-200 transition">
                        <i class="fa-solid fa-dog mr-1"></i>Mascotas
                    </a>
                    <a href="{{ route('turnos.index') }}" class="text-white text-xs hover:text-purple-200 transition">
                        <i class="fa-solid fa-calendar mr-1"></i>Turnos
                    </a>
                    <a href="{{ route('ventas.index') }}" class="text-white text-xs hover:text-purple-200 transition">
                        <i class="fa-solid fa-cash-register mr-1"></i>Ventas
                    </a>
                    <a href="{{ route('productos.index') }}" class="text-white text-xs hover:text-purple-200 transition">
                        <i class="fa-solid fa-box mr-1"></i>Productos
                    </a>
                    <a href="{{ route('servicios.index') }}" class="text-white text-xs hover:text-purple-200 transition">
                        <i class="fa-solid fa-scissors mr-1"></i>Servicios
                    </a>
                    <a href="{{ route('categorias.index') }}" class="text-white text-xs hover:text-purple-200 transition">
                        <i class="fa-solid fa-tags mr-1"></i>Categorías
                    </a>
                    @can('admin')
                    <a href="{{ route('proveedores.index') }}" class="text-white text-xs hover:text-purple-200 transition">
                        <i class="fa-solid fa-truck mr-1"></i>Proveedores
                    </a>
                    <a href="{{ route('compras.index') }}" class="text-white text-xs hover:text-purple-200 transition">
                        <i class="fa-solid fa-cart-shopping mr-1"></i>Compras
                    </a>
                    <a href="{{ route('stock.index') }}" class="text-white text-xs hover:text-purple-200 transition">
                        <i class="fa-solid fa-warehouse mr-1"></i>Stock
                    </a>
                    <a href="{{ route('empleados.index') }}" class="text-white text-xs hover:text-purple-200 transition">
                        <i class="fa-solid fa-id-badge mr-1"></i>Empleados
                    </a>
                    @endcan
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white hover:text-purple-200 focus:outline-none transition">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                            <svg class="fill-current h-4 w-4 ms-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            <i class="fa-solid fa-user mr-2"></i>Perfil
                        </x-dropdown-link>
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                <i class="fa-solid fa-right-from-bracket mr-2"></i>Salir
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-purple-200 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-purple-800">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-white hover:bg-purple-700">Dashboard</a>
            <a href="{{ route('clientes.index') }}" class="block px-4 py-2 text-white hover:bg-purple-700">Clientes</a>
            <a href="{{ route('mascotas.index') }}" class="block px-4 py-2 text-white hover:bg-purple-700">Mascotas</a>
            <a href="{{ route('turnos.index') }}" class="block px-4 py-2 text-white hover:bg-purple-700">Turnos</a>
            <a href="{{ route('ventas.index') }}" class="block px-4 py-2 text-white hover:bg-purple-700">Ventas</a>
            <a href="{{ route('productos.index') }}" class="block px-4 py-2 text-white hover:bg-purple-700">Productos</a>
            <a href="{{ route('servicios.index') }}" class="block px-4 py-2 text-white hover:bg-purple-700">Servicios</a>
            <a href="{{ route('categorias.index') }}" class="block px-4 py-2 text-white hover:bg-purple-700">Categorias</a>
            @can('admin')
            <a href="{{ route('proveedores.index') }}" class="block px-4 py-2 text-white hover:bg-purple-700">Proveedores</a>
            <a href="{{ route('compras.index') }}" class="block px-4 py-2 text-white hover:bg-purple-700">Compras</a>
            <a href="{{ route('stock.index') }}" class="block px-4 py-2 text-white hover:bg-purple-700">Stock</a>
            <a href="{{ route('empleados.index') }}" class="block px-4 py-2 text-white hover:bg-purple-700">Empleados</a>
            @endcan
        </div>
        <div class="pt-4 pb-1 border-t border-purple-600">
            <div class="px-4">
                <div class="font-medium text-base text-white" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-purple-300">{{ auth()->user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile') }}" class="block px-4 py-2 text-white hover:bg-purple-700">Perfil</a>
                <button wire:click="logout" class="w-full text-start block px-4 py-2 text-white hover:bg-purple-700">Salir</button>
            </div>
        </div>
    </div>
</nav>