<?php

namespace App\Policies;

use App\Models\Servicio;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServicioPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Servicio $servicio): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function update(User $user, Servicio $servicio): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function delete(User $user, Servicio $servicio): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Servicio $servicio): bool
    {
        return false;
    }

    public function forceDelete(User $user, Servicio $servicio): bool
    {
        return false;
    }
}