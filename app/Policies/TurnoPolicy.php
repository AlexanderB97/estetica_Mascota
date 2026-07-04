<?php

namespace App\Policies;

use App\Models\Turno;
use App\Models\User;

class TurnoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Turno $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function update(User $user, Turno $model): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function delete(User $user, Turno $model): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Turno $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Turno $model): bool
    {
        return false;
    }
}