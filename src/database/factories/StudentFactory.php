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
            'apellido' => $this->faker->lastName(),
            'nombre' => $this->faker->name(),
            'dni' => $this->faker->randomNumber(9, $strict = true),
            'telefono' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'direccion' => $this->faker->address()
        ];
    }
}
