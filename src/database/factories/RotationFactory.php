<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class RotationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'numero' => 1,
            'fecha' => Carbon::now(),
            'observaciones' => "Lorem ipsum, dolor sit amet consectetur adipisicing elit.",
        ];
    }
}
