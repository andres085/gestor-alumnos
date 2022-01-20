<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentAttendanceFactory extends Factory
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
            'attendance_id' => function () {
                return Attendance::factory()->create()->id;
            },
            'presente' => $this->faker->boolean(),
            'ausente' => $this->faker->boolean()
        ];
    }
}
