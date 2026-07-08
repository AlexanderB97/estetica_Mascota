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
               // 1. Administrador fijo (mínimo 8 caracteres)
        User::factory()->admin()->create([
            'name' => 'Administrador Tienda',
            'email' => 'admin@tienda.com',
            'password' => bcrypt('admin1234'), // Cambiado a admin1234 (9 caracteres)
        ]);

        // 2. Vendedor fijo (mínimo 8 caracteres)
        User::factory()->vendedor()->create([
            'name' => 'Vendedor Test',
            'email' => 'vendedor@tienda.com',
            'password' => bcrypt('vendedor123'), // Tiene 11 caracteres (Correcto)
        ]);

        // 3. Generamos 10 usuarios vendedores aleatorios para tener volumen de datos
        User::factory()->count(10)->vendedor()->create();

        // 4. LLAMAR AL SEEDER DE LAS APIs Y PANEL ADMINISTRATIVO
        $this->call(TiendaMascotasSeeder::class);
    }
}
