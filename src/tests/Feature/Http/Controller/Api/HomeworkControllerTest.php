<?php

namespace Tests\Feature\Http\Controller\Api;

use Tests\TestCase;
use App\Models\Homework;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomeworkControllerTest extends TestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;

    public function test_can_create_a_homework()
    {
        $this->withoutExceptionHandling();

        $homework = Homework::factory()->create();

        $response = $this->json('POST', '/api/homework', $homework->toArray());

        $response->assertStatus(201)->assertJsonStructure(['tarea', 'observacion', 'fecha_entrega', 'calificacion']);

        $this->assertDatabaseHas('homework', [
            'tarea' => $homework->tarea,
            'observacion' => $homework->observacion,
            'fecha_entrega' => $homework->fecha_entrega,
            'calificacion' => $homework->calificacion,
        ]);
    }

    public function test_can_get_all_homeworks_from_an_student()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_error_404_if_homework_not_found()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_return_a_homework()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_error_404_if_homework_to_update_not_found()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_update_a_homework()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_error_404_if_homework_to_delete_not_found()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_delete_a_homework()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
