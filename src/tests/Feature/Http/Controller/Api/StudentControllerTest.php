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

    public function test_error_404_if_student_not_found()
    {

        $response = $this->get('api/students/-1');

        $response->assertStatus(404);
    }

    public function test_can_return_a_student()
    {

        $student = Student::factory()->create();

        $response = $this->get('api/students/'.$student->id);

        $response->assertStatus(200)
        ->assertExactJson([
            'id' => $student->id,
            'apellido' => $student->apellido,
            'nombre' => $student->nombre,
            'dni' => (string)$student->dni,
            'telefono' => $student->telefono,
            'email' => $student->email,
            'direccion' => $student->direccion,
        ]);
        
    }

    public function test_will_fail_is_student_to_update_is_not_found()
    {

        $response = $this->put('api/students/-1');

        $response->assertStatus(404);

    }

    public function test_can_update_a_student()
    {

        $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $response = $this->put('api/students/'.$student->id, [
            'id' => $student->id,
            'apellido' => 'Paquito',
            'nombre' => $student->nombre,
            'dni' => (string)$student->dni,
            'telefono' => $student->telefono,
            'email' => $student->email,
            'direccion' => 'Las Heras 1732',
        ]);

        $response->assertStatus(200)->assertJson([
            'apellido' => 'Paquito',
            'direccion' => 'Las Heras 1732',
        ]);

    }

    public function test_will_fail_is_student_to_be_deleted_is_not_found()
    {
        
        $response = $this->delete('api/students/-1');

        $response->assertStatus(404);

    }

    public function test_a_student_can_be_deleted()
    {

        $student = Student::factory()->create();

        $response = $this->delete('api/students/'.$student->id);

        $this->assertDatabaseMissing('students', $student->toArray());
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
