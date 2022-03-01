<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\StudentAttendance;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AttendanceTest extends TestCase
{

    use DatabaseMigrations;

    public function test_an_attendance_has_many_students_through_pivot_table()
    {
        $attendance = Attendance::factory()->create();

        $student1 = Student::factory()->create();
        $student2 = Student::factory()->create();
        $student3 = Student::factory()->create();

        StudentAttendance::factory()->create([
            'attendance_id' => $attendance->id,
            'student_id' => $student1->id,
        ]);

        StudentAttendance::factory()->create([
            'attendance_id' => $attendance->id,
            'student_id' => $student2->id,
        ]);

        StudentAttendance::factory()->create([
            'attendance_id' => $attendance->id,
            'student_id' => $student3->id,
        ]);

        $this->assertEquals(3, $attendance->students->count());
    }
}
