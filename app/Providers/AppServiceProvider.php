<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('vendedor', function ($user) {
            return in_array($user->role, ['admin', 'vendedor']);
        });
    }
}
