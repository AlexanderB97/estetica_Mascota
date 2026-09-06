<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirect(route('dashboard'), navigate: true);
    }
}; ?>

<div>
    <!-- Título -->
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-gray-800">Iniciar sesión</h2>
        <p class="text-sm text-gray-500 mt-1">Ingresá tus credenciales para continuar</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Correo electrónico" />
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-purple-400">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <x-text-input
                    wire:model="form.email"
                    id="email"
                    class="block w-full pl-10 bg-purple-50/60 focus:bg-white transition"
                    type="email"
                    name="email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="nombre@ejemplo.com"
                />
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Contraseña" />
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-purple-400">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <x-text-input
                    wire:model="form.password"
                    id="password"
                    class="block w-full pl-10 bg-purple-50/60 focus:bg-white transition"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-purple-600 hover:text-purple-800 underline-offset-2 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" href="{{ route('password.request') }}" wire:navigate>
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-purple-700 to-pink-500 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest shadow-md hover:from-purple-800 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 active:scale-[0.99] transition ease-in-out duration-150">
            <i class="fa-solid fa-right-to-bracket"></i>
            Ingresar
        </button>
    </form>
</div>