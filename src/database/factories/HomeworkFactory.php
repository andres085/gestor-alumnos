<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class HomeworkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'student_id' => function () {
                return Student::factory()->create()->id;
            },
            'tarea' => $this->faker->word(),
            'observacion' => $this->faker->text($maxNbChars = 50),
            'fecha_entrega' => Carbon::parse('+1 week'),
            'calificacion' => $this->faker->numberBetween($min = 4, $max = 10),
        ];
    }
}
