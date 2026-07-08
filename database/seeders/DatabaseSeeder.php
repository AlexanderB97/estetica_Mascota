<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Creamos un Administrador fijo para que tú y tu equipo puedan loguearse
        User::factory()->admin()->create([
            'name' => 'Administrador Tienda',
            'email' => 'admin@tienda.com',
            'password' => bcrypt('admin123'), // Contraseña fácil para desarrollo
        ]);

        // 2. Creamos un Vendedor fijo para probar el otro rol de la app
        User::factory()->vendedor()->create([
            'name' => 'Vendedor Test',
            'email' => 'vendedor@tienda.com',
            'password' => bcrypt('vendedor123'),
        ]);

        // 3. Generamos 10 usuarios vendedores aleatorios para tener volumen de datos
        User::factory()->count(10)->vendedor()->create();
    }
}
