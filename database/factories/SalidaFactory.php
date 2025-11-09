<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SalidaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tipo_salida' => $this->faker->randomElement([
                'Compra de materiales',
                'Pago de servicios',
                'Salario empleado',
                'Mantenimiento',
                'Gasto administrativo',
            ]),
            'monto' => $this->faker->randomFloat(2, 30, 2000),
            'fecha' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'factura' => null,
        ];
    }
}
