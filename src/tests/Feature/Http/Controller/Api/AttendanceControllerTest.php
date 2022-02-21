<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Attendance;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AttendanceControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->attendance = Attendance::factory()->create();
    }


    public function test_can_create_an_attendance()
    {
        $response = $this->json('POST', 'api/attendances', $this->attendance->toArray());

        $response->assertStatus(201)->assertJsonStructure(['id', 'tema', 'fecha']);

        $this->assertDatabaseHas('attendances', [
            'id' => $this->attendance->id,
            'tema' => $this->attendance->tema,
            'fecha' => $this->attendance->fecha
        ]);
    }

    public function test_can_get_all_attendances()
    {

        $response = $this->json('GET', 'api/attendances');

        $response->assertStatus(200);
    }

    public function test_error_404_if_attendance_not_found()
    {
        $response = $this->json('GET', 'api/attendances/-1');

        $response->assertStatus(404);
    }

    public function test_can_return_an_attendance()
    {
        $response = $this->json('GET', "api/attendances/{$this->attendance->id}");

        $response->assertStatus(200)->assertJson($this->attendance->toArray());
    }

    public function test_error_404_if_attendance_to_update_not_found()
    {
        $response = $this->json('PUT', "api/attendances/-1");

        $response->assertStatus(404);
    }

    public function test_can_update_an_attendance()
    {
        $attendance = Attendance::factory()->create([
            'tema' => 'Electricidad Introducción'
        ]);

        $response = $this->json('PUT', "api/attendances/{$attendance->id}", $attendance->toArray());

        $response->assertStatus(200)->assertJson(['tema' => $attendance->tema]);
    }

    public function test_error_404_if_attendance_to_delete_not_found()
    {

        $response = $this->json('DELETE', "api/attendances/-1");

        $response->assertStatus(404);
    }

    public function test_can_delete_an_attendance()
    {
        $response = $this->json('DELETE', "api/attendances/{$this->attendance->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('attendances', $this->attendance->toArray());
    }

    public function test_fecha_field_is_required()
    {
        $response = $this->json('POST', 'api/attendances', [
            'tema' => 'Tema Nuevo',
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.fecha', ["El campo fecha es requerido"]);
    }
}
