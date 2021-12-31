<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'apellido' => 'Martinez',
            'nombre' => 'Andrés',
            'dni' => 31794897,
            'telefono' => '2920-542448',
            'email' => 'andresm.webdev@gmail.com',
            'direccion' => 'Colapiche 183'
        ];
    }
}
