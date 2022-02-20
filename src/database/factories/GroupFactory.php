<?php

namespace Database\Factories;

use App\Models\Rotation;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'numero' => $this->faker->numberBetween(1, 2),
            'rotation_id' => function () {
                return Rotation::factory()->create()->id;
            },
        ];
    }
}
