<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Cliente;
use App\Models\Mascota;
use App\Models\Proveedor;
use App\Models\Empleado;
use App\Models\MovimientoStock;
use App\Models\User;

class TiendaMascotasSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener el Administrador para auditorías de stock
        $adminUser = User::where('role', 'admin')->first();
        $adminId = $adminUser ? $adminUser->id : 1;

        // ==========================================================
        // 1. PRODUCTOS Y CATEGORÍAS (CON STOCK Y CATEGORIA STRING)
        // ==========================================================
        $categoriaCosmeticos = Categoria::firstOrCreate([
            'nombre' => 'Estética y Cosmética',
            'descripcion' => 'Champús, lociones y artículos de higiene para mascotas'
        ]);

        try {
            $responseProducts = Http::timeout(5)->get('https://dummyjson.com/products');
            
            if ($responseProducts->successful() && isset($responseProducts->json()['products'])) {
                $data = $responseProducts->json();
                foreach ($data['products'] as $item) {
                    $nombreMascota = str_replace(
                        ['Eyeshadow', 'Lipstick', 'Mascara', 'Nail Polish'], 
                        ['Champú Brillo', 'Bálsamo Almohadillas', 'Loción Desenredante', 'Perfume Canino'], 
                        $item['title']
                    );

                    Producto::create([
                        'nombre'       => $nombreMascota,
                        'descripcion'  => $item['description'],
                        'precio'       => $item['price'],
                        'stock'        => rand(10, 30), // Columna obligatoria reparada
                        'categoria'    => $categoriaCosmeticos->nombre, // Columna string corregida
                        'categoria_id' => $categoriaCosmeticos->id,
                    ]);
                }
            } else {
                throw new \Exception("API no disponible");
            }
        } catch (\Exception $e) {
            $productosRespaldo = [
                ['nombre' => 'Champú Brillo Esencial', 'desc' => 'Champú neutro para todo tipo de pelajes.', 'precio' => 45.00],
                ['nombre' => 'Bálsamo Almohadillas Hidratante', 'desc' => 'Crema protectora para patitas resecas.', 'precio' => 32.00],
                ['nombre' => 'Loción Desenredante Express', 'desc' => 'Spray para remover nudos sin tirones.', 'precio' => 51.00],
                ['nombre' => 'Perfume Canino Frutal', 'desc' => 'Colonia de larga duración libre de alcohol.', 'precio' => 28.00],
            ];

            foreach ($productosRespaldo as $prod) {
                Producto::create([
                    'nombre'       => $prod['nombre'],
                    'descripcion'  => $prod['desc'],
                    'precio'       => $prod['precio'],
                    'stock'        => rand(10, 30), // Columna obligatoria reparada
                    'categoria'    => $categoriaCosmeticos->nombre, // Columna string corregida
                    'categoria_id' => $categoriaCosmeticos->id,
                ]);
            }
        }

        // ==========================================================
        // 2. SERVICIOS (CON DURACION_MINUTOS)
        // ==========================================================
        $serviciosEstetica = [
            ['nombre' => 'Baño y Corte Completo', 'descripcion' => 'Incluye baño higiénico, corte de pelo según raza y secado.', 'precio' => 250.00, 'duracion' => 60],
            ['nombre' => 'Corte de Uñas e Higiene', 'descripcion' => 'Limpieza de oídos, vaciado de glándulas y corte de uñas.', 'precio' => 80.00, 'duracion' => 20],
            ['nombre' => 'Baño Medicado Alergias', 'descripcion' => 'Baño especial con champú dermatológico para pieles sensibles.', 'precio' => 180.00, 'duracion' => 45],
        ];

        foreach ($serviciosEstetica as $servicio) {
            Servicio::create([
                'nombre'           => $servicio['nombre'],
                'descripcion'      => $servicio['descripcion'],
                'precio'           => $servicio['precio'],
                'duracion_minutos' => $servicio['duracion'] // Nombre de columna corregido
            ]);
        }

        // ==========================================================
        // 3. COMPLEMENTOS PANEL ADMIN: PROVEEDORES, EMPLEADOS Y STOCK
        // ==========================================================
        
        // A) Proveedores
        $proveedoresFijos = [
            ['nombre' => 'Distribuidora Canina S.A.', 'telefono' => '1122334455', 'email' => 'contacto@districan.com', 'direccion' => 'Av. Industrial 450'],
            ['nombre' => 'Cosmética Animal Mayorista', 'telefono' => '1155667788', 'email' => 'ventas@cosmeticanimal.com', 'direccion' => 'Ruta 3 Kilómetro 20'],
        ];
        foreach ($proveedoresFijos as $prov) {
            Proveedor::create($prov);
        }

        // B) Empleados
        $usuariosVendedores = User::where('role', 'vendedor')->get();
        foreach ($usuariosVendedores as $index => $user) {
            Empleado::create([
                'user_id'       => $user->id,
                'legajo'        => 'LEG-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'dni'           => fake()->numerify('########'),
                'telefono'      => fake()->phoneNumber(),
                'direccion'     => fake()->address(),
                'fecha_ingreso' => fake()->dateTimeBetween('-2 years', '-1 month')->format('Y-m-d'),
                'activo'        => true,
            ]);
        }

        // C) Movimientos de Stock
        $todosLosProductos = Producto::all();
        foreach ($todosLosProductos as $producto) {
            MovimientoStock::create([
                'producto_id' => $producto->id,
                'usuario_id'  => $adminId,
                'tipo'        => 'entrada',
                'cantidad'    => $producto->stock,
                'motivo'      => 'Carga inicial'
            ]);
        }

        // ==========================================================
        // 4. CLIENTES Y MASCOTAS (CON PROTECCIÓN CONTRA CAÍDAS DE API)
        // ==========================================================
        $razasPerros = ['Criollo', 'Poodle', 'Labrador', 'Golden', 'Ovejero Alemania', 'Chihuahua'];
        $razasGatos  = ['Persa', 'Siamés', 'Mestizo', 'Bengala', 'Angora'];

        try {
            $resPerros = Http::timeout(5)->get('https://dog.ceo/api/breeds/list/all');
            if ($resPerros->successful() && isset($resPerros->json()['message'])) {
                $razasPerros = array_keys($resPerros->json()['message']);
            }
        } catch (\Exception $e) {
            // Si falla la API de perros, continúa con la lista de respaldo
        }

        try {
            $resGatos = Http::timeout(5)->get('https://thecatapi.com/v1/breeds');
            if ($resGatos->successful() && is_array($resGatos->json())) {
                $razasGatos = array_column($resGatos->json(), 'name');
            }
        } catch (\Exception $e) {
            // Si falla la API de gatos, continúa con la lista de respaldo
        }

        $razasEspeciesPequeñas = [
            'conejo'  => ['Cabeza de león', 'Angora'],
            'ave'     => ['Canario', 'Periquito'],
            'hamster' => ['Ruso', 'Roborovski'],
            'otro'    => ['Mestizo']
        ];

        for ($i = 1; $i <= 15; $i++) {
            $cliente = Cliente::create([
                'nombre'    => fake()->firstName(),
                'apellido'  => fake()->lastName(),
                'telefono'  => fake()->phoneNumber(),
                'email'     => fake()->unique()->safeEmail(),
                'direccion' => fake()->address()
            ]);

            $cantidadMascotas = rand(1, 2);
            for ($j = 0; $j < $cantidadMascotas; $j++) {
                $especiesDisponibles = ['perro', 'gato', 'conejo', 'ave', 'hamster', 'otro'];
                $especieElegida      = fake()->randomElement($especiesDisponibles);
                
                if ($especieElegida === 'perro') {
                    $razaElegida = ucfirst(fake()->randomElement($razasPerros));
                } elseif ($especieElegida === 'gato') {
                    $razaElegida = fake()->randomElement($razasGatos);
                } else {
                    $razaElegida = fake()->randomElement($razasEspeciesPequeñas[$especieElegida]);
                }

                Mascota::create([
                    'cliente_id'       => $cliente->id,
                    'nombre'           => fake()->firstName(),
                    'especie'          => $especieElegida,
                    'raza'             => $razaElegida,
                    'fecha_nacimiento' => fake()->dateTimeBetween('-8 years', '-3 months')->format('Y-m-d')
                ]);
            }
        }
    }
}
