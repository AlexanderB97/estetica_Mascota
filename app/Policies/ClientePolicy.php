<?php

namespace App\Policies;

use App\Models\Cliente;
use App\Models\User;

class ClientePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Cliente $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function update(User $user, Cliente $model): bool
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function delete(User $user, Cliente $model): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Cliente $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Cliente $model): bool
    {
        return false;
    }
}