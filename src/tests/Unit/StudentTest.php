<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Group;
use App\Models\Student;
use App\Models\Homework;
use App\Models\Rotation;
use App\Models\StudentAttendance;
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

        Homework::factory()->create([
            'student_id' => $student->id
        ]);

        Homework::factory()->create([
            'student_id' => $student->id
        ]);

        Homework::factory()->create([
            'student_id' => $student->id
        ]);

        $this->assertEquals(3, $student->homeworks->count());
    }

    public function test_a_student_has_many_attendances_through_pivot_table()
    {
        $student = Student::factory()->create();

        StudentAttendance::factory()->create([
            'student_id' => $student->id,
        ]);

        StudentAttendance::factory()->create([
            'student_id' => $student->id,
        ]);

        StudentAttendance::factory()->create([
            'student_id' => $student->id,
        ]);

        $this->assertEquals(3, $student->attendance->count());
    }

    public function test_a_student_belongs_to_a_group()
    {
        $group = Group::factory()->create();

        $student = Student::factory()->create([
            'group_id' => $group->id
        ]);

        $this->assertEquals(1, $student->group->count());
        $this->assertInstanceOf(Group::class, $student->group);
    }
}
