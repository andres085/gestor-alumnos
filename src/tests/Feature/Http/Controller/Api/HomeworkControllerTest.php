<?php

namespace Tests\Feature\Http\Controller\Api;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Homework;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomeworkControllerTest extends TestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->homework = Homework::factory()->create();
    }

    public function test_can_create_a_homework()
    {
        $this->withoutExceptionHandling();

        $response = $this->json('POST', '/api/homework', $this->homework->toArray());

        $response->assertStatus(201)->assertJsonStructure(['tarea', 'observacion', 'fecha_entrega', 'calificacion']);

        $this->assertDatabaseHas('homework', [
            'tarea' => $this->homework->tarea,
            'observacion' => $this->homework->observacion,
            'fecha_entrega' => $this->homework->fecha_entrega,
            'calificacion' => $this->homework->calificacion,
        ]);
    }

    public function test_can_get_all_homeworks_from_an_student()
    {

        $student = Student::factory()->create();

        $homeworks = [
            Homework::factory()->create(['student_id' => $student->id]),
            Homework::factory()->create(['student_id' => $student->id]),
            Homework::factory()->create(['student_id' => $student->id]),
        ];

        $response = $this->json('GET', '/api/homework?=', ['student_id' => $student->id]);

        $response->assertStatus(200);
        $this->assertEquals($homeworks[0]->student_id, $student->id);
        $this->assertEquals($homeworks[1]->student_id, $student->id);
        $this->assertEquals($homeworks[2]->student_id, $student->id);
    }

    public function test_error_404_if_homework_not_found()
    {
        $response = $this->json('GET', '/api/homework/-1');

        $response->assertStatus(404);
    }

    public function test_can_return_a_homework()
    {
        $response = $this->json('GET', "/api/homework/{$this->homework->id}");

        $response->assertStatus(200)->assertJsonPath('id', $this->homework->id);
    }

    public function test_error_404_if_homework_to_update_not_found()
    {
        $response = $this->json('PUT', '/api/homework/-1');

        $response->assertStatus(404);
    }

    public function test_can_update_a_homework()
    {

        $homework = Homework::factory()->create([
            'tarea' => 'Circuitos Paralelo',
        ]);

        $response = $this->json('PUT', "/api/homework/{$homework->id}", $homework->toArray());

        $response->assertStatus(200)->assertJson([
            'tarea' => $homework->tarea
        ]);
    }

    public function test_error_404_if_homework_to_delete_not_found()
    {
        $response = $this->json('DELETE', '/api/homework/-1');

        $response->assertStatus(404);
    }

    public function test_can_delete_a_homework()
    {
        $response = $this->json('DELETE', "/api/homework/{$this->homework->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('homework', $this->homework->toArray());
    }

    public function test_that_tarea_field_is_required()
    {
        $response = $this->json('POST', '/api/homework', [
            'observacion' => 'Observacion test',
            'fecha_entrega' => Carbon::now(),
            'calificacion' => 7
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.tarea', ["El campo tarea es requerido"]);
    }

    public function test_that_tarea_field_text_only()
    {
        $response = $this->json('POST', '/api/homework', [
            'tarea' => 11234,
            'observacion' => 'Observacion test',
            'fecha_entrega' => Carbon::now(),
            'calificacion' => 7
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.tarea', ["El campo tarea es de solo texto"]);
    }

    public function test_that_fecha_field_is_required()
    {
        $response = $this->json('POST', '/api/homework', [
            'tarea' => 'Tarea Circuitos',
            'observacion' => 'Observacion test',
            'calificacion' => 7
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.fecha_entrega', ["El campo fecha entrega es requerido"]);
    }
}
