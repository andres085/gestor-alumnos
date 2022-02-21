<?php

namespace Tests\Unit;

use App\Models\Homework;
use Tests\TestCase;
use App\Models\Student;
use App\Models\Rotation;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StudentTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_student_belongs_to_a_rotation()
    {
        $rotation = Rotation::factory()->create();

        $student = Student::factory()->create([
            'rotation_id' => $rotation->id
        ]);

        $this->assertEquals(1, $student->rotation->count());
        $this->assertInstanceOf(Rotation::class, $student->rotation);
    }

    public function test_a_student_has_many_homework()
    {
        $student = Student::factory()->create();

        $homework1 = Homework::factory()->create([
            'student_id' => $student->id
        ]);

        $homework2 = Homework::factory()->create([
            'student_id' => $student->id
        ]);

        $homework3 = Homework::factory()->create([
            'student_id' => $student->id
        ]);

        $this->assertEquals(3, $student->homeworks->count());
    }
}
