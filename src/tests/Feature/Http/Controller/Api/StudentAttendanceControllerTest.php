<?php

namespace Tests\Feature\Http\Controller\Api;

use Tests\TestCase;
use App\Models\StudentAttendance;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StudentAttendanceControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function test_can_create_an_student_attendance_relation()
    {
        $this->withoutExceptionHandling();

        $studentAttendances = [
            StudentAttendance::factory()->create([
                'presente' => true,
            ]),
            StudentAttendance::factory()->create([
                'ausente' => true,
            ]),
            StudentAttendance::factory()->create([
                'presente' => true,
            ]),
        ];

        $response = $this->json('POST', 'api/student-attendances', $studentAttendances);

        $response->assertStatus(201);

        $this->assertDatabaseHas(
            'student_attendances',
            [
                'id' => $studentAttendances[0]->id
            ]
        );
    }
}
