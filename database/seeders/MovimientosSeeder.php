<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entrada;
use App\Models\Salida;

class MovimientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 25 entradas de prueba
        Entrada::factory()->count(25)->create();

        // Crear 20 salidas de prueba
        Salida::factory()->count(20)->create();
    }
}
