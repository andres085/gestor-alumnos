<?php

namespace Tests\Feature\Http\Controller\Api;

use Tests\TestCase;
use App\Models\Attendance;
use App\Models\StudentAttendance;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StudentAttendanceControllerTest extends TestCase
{

    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->attendance = Attendance::factory()->create();
    }


    public function test_can_create_an_student_attendance_relation()
    {
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
        $studentAttendances = [
            StudentAttendance::factory()->create([
                'attendance_id' => $this->attendance->id,
                'presente' => true,
            ])
        ];

        $response1 = $this->json('POST', 'api/attendances', $this->attendance->toArray());

        $response1->assertStatus(201);
        $this->assertDatabaseHas('attendances', [
            'id' => $this->attendance->id,
            'tema' => $this->attendance->tema,
            'fecha' => $this->attendance->fecha
        ]);

        $response2 = $this->json('POST', 'api/student-attendances', $studentAttendances);

        $response2->assertStatus(201);
        $this->assertDatabaseHas(
            'student_attendances',
            [
                'attendance_id' => $this->attendance->id,
                'id' => $studentAttendances[0]->id
            ]
        );

        $response1 = $this->json('DELETE', "api/attendances/{$this->attendance->id}");

        $response1->assertStatus(204);
        $this->assertDatabaseMissing('attendances', $this->attendance->toArray());
        $this->assertDatabaseMissing('student_attendances', $studentAttendances[0]->toArray());
    }

    public function test_can_update_the_student_attendance()
    {
        $studentAttendances = [
            StudentAttendance::factory()->create([
                'attendance_id' => $this->attendance->id,
                'presente' => true,
            ]),
            StudentAttendance::factory()->create([
                'attendance_id' => $this->attendance->id,
                'presente' => false,
            ]),
        ];

        $response = $this->json('PUT', "api/student-attendances/$this->attendance->id", $studentAttendances);

        $response->assertStatus(200);

        $this->assertTrue($studentAttendances[0]->presente);
        $this->assertFalse($studentAttendances[1]->presente);
    }
}
