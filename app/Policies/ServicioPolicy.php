<?php

namespace App\Policies;

use App\Models\Servicio;
use App\Models\User;

class ServicioPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Servicio $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function update(User $user, Servicio $model): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function delete(User $user, Servicio $model): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Servicio $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Servicio $model): bool
    {
        return false;
    }
}