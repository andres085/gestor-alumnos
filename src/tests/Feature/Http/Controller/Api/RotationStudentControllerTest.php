<?php

namespace Tests\Feature\Http\Controller\Api;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Rotation;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RotationStudentControllerTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function can_get_students_from_a_rotation()
    {

        $this->withoutExceptionHandling();

        $rotation = Rotation::factory()->create();

        $student1 = Student::factory()->create([
            'rotation_id' => $rotation->id
        ]);

        $response = $this->getJson("api/rotations/{$rotation->id}/students")
            ->assertStatus(200);


        $response->assertJsonStructure([
            '*' => ['apellido', 'nombre', 'telefono'],
        ]);

        $response->assertJsonFragment([
            'id' => $student1->id,
        ]);
    }
}
