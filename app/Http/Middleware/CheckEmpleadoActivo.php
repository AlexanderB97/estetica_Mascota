<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckEmpleadoActivo
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->empleado && !$user->empleado->activo) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->withErrors([
                'email' => 'Tu cuenta está desactivada. Contactá al administrador.',
            ]);
        }

        return $next($request);
    }
}