<?php

namespace App\Policies;

use App\Models\Mascota;
use App\Models\User;

class MascotaPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Mascota $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function update(User $user, Mascota $model): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function delete(User $user, Mascota $model): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Mascota $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Mascota $model): bool
    {
        return false;
    }
}