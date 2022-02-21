<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Student;
use App\Models\Rotation;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RotationTest extends TestCase
{

    use DatabaseMigrations;

    public function test_format_fecha_to_day_month_year()
    {
        $rotation = Rotation::factory()->make([
            'fecha' => Carbon::parse('2021-12-01'),
        ]);

        $this->assertEquals('01/12/2021', $rotation->formatted_date);
    }

    public function test_return_all_students_in_a_rotation()
    {
        $rotation = Rotation::factory()->create();

        $student1 = Student::factory()->create([
            'rotation_id' => $rotation->id
        ]);

        $this->assertTrue($rotation->students->contains($student1));
        $this->assertEquals(1, $rotation->students->count());
    }
}
