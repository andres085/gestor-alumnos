<?php

namespace Tests\Feature\Http\Controller\Api;

use Tests\TestCase;
use App\Models\Attendance;
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

    public function test_a_relationship_is_deleted_if_attendance_is_deleted()
    {
        $this->withoutExceptionHandling();

        $attendance = Attendance::factory()->create();

        $studentAttendances = [
            StudentAttendance::factory()->create([
                'attendance_id' => $attendance->id,
                'presente' => true,
            ])
        ];


        $response1 = $this->json('POST', 'api/attendances', $attendance->toArray());

        $response1->assertStatus(201);

        $this->assertDatabaseHas('attendances', [
            'id' => $attendance->id,
            'tema' => $attendance->tema,
            'fecha' => $attendance->fecha
        ]);

        $response2 = $this->json('POST', 'api/student-attendances', $studentAttendances);

        $response2->assertStatus(201);

        $this->assertDatabaseHas(
            'student_attendances',
            [
                'attendance_id' => $attendance->id,
                'id' => $studentAttendances[0]->id
            ]
        );

        $response1 = $this->json('DELETE', "api/attendances/{$attendance->id}");

        $response1->assertStatus(204);

        $this->assertDatabaseMissing('attendances', $attendance->toArray());

        $this->assertDatabaseMissing('student_attendances', $studentAttendances[0]->toArray());
    }

    public function test_can_update_the_student_attendance()
    {

        $this->withoutExceptionHandling();

        $attendance = Attendance::factory()->create();

        $studentAttendances = [
            StudentAttendance::factory()->create([
                'attendance_id' => $attendance->id,
                'presente' => true,
            ]),
            StudentAttendance::factory()->create([
                'attendance_id' => $attendance->id,
                'presente' => false,
            ]),
        ];

        $response = $this->json('PUT', "api/student-attendances/$attendance->id", $studentAttendances);

        $response->assertStatus(200);

        $this->assertTrue($studentAttendances[0]->presente);
        $this->assertFalse($studentAttendances[1]->presente);
    }
}
