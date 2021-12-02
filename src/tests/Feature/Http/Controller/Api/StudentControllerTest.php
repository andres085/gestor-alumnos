<?php

namespace Tests\Feature\Http\Controller\Api;

use Tests\TestCase;
use App\Models\Student;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StudentControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function test_can_create_a_student()
    {

        $student = Student::factory()->create();

        $response = $this->post('/api/students', $student->toArray());

        $response->assertJsonStructure(['id', 'apellido', 'nombre', 'dni', 'telefono', 'email', 'direccion'])->assertStatus(201);

        $this->assertDatabaseHas('students', [
            'dni' => $student->dni
        ]);
    }

    public function test_can_return_a_student()
    {

        $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $response = $this->get('api/students/'.$student->id);

        $response->assertJsonStructure(['id', 'apellido', 'nombre', 'dni', 'telefono', 'email', 'direccion'])->assertStatus(200);
        
    }
    // public function test_apellido_is_required()
    // {
    //     $student = Student::factory()->create();

    //     $response = $this->json('POST', '/api/students', [
    //         'nombre' => 'Andrés',
    //         'dni' => 31794897,
    //         'telefono' => '2920-542448',
    //         'email' => 'andres@mail.com',
    //         'direccion' => 'Colapiche 183'
    //     ]);

    //     $this->assertHasValidationError('apellido', $response);
    // }
}
