<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EntradaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo_entrada' => $this->faker->randomElement([
                'Venta de producto',
                'Servicio prestado',
                'Pago recibido',
                'Interés bancario',
                'Otro ingreso',
            ]),
            'monto' => $this->faker->randomFloat(2, 50, 3000), // entre 50 y 3000
            'fecha' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'factura' => null, // podés cambiar esto por una ruta si querés probar archivos
        ];
    }
}
