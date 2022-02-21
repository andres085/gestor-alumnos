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

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = Student::factory()->create();
    }


    public function test_can_create_a_student()
    {
        $response = $this->json('POST', 'api/students', $this->student->toArray());

        $response->assertStatus(201)->assertJsonStructure(['id', 'apellido', 'nombre', 'dni', 'telefono', 'email', 'direccion']);

        $this->assertDatabaseHas('students', [
            'dni' => $this->student->dni
        ]);
    }

    public function test_can_get_all_students()
    {
        $response = $this->json('GET', 'api/students');

        $response->assertStatus(200)->assertJson([
            [
                'id' => $this->student->id,
            ]
        ]);;
    }

    public function test_error_404_if_student_not_found()
    {

        $response = $this->json('GET', 'api/students/-1');

        $response->assertStatus(404);
    }

    public function test_can_return_a_student()
    {
        $response = $this->json('GET', "api/students/{$this->student->id}");

        $response->assertStatus(200)
            ->assertExactJson([
                'id' => $this->student->id,
                'apellido' => $this->student->apellido,
                'nombre' => $this->student->nombre,
                'dni' => (string)$this->student->dni,
                'telefono' => $this->student->telefono,
                'email' => $this->student->email,
                'direccion' => $this->student->direccion,
                'rotation_id' => null,
            ]);
    }

    public function test_will_fail_is_student_to_update_is_not_found()
    {

        $response = $this->json('PUT', 'api/students/-1');

        $response->assertStatus(404);
    }

    public function test_can_update_a_student()
    {

        $this->withoutExceptionHandling();

        $response = $this->json('PUT', "api/students/{$this->student->id}", [
            'id' => $this->student->id,
            'apellido' => 'Paquito',
            'nombre' => $this->student->nombre,
            'dni' => (string)$this->student->dni,
            'telefono' => $this->student->telefono,
            'email' => $this->student->email,
            'direccion' => 'Las Heras 1732',
        ]);

        $response->assertStatus(200)->assertJson([
            'apellido' => 'Paquito',
            'direccion' => 'Las Heras 1732',
        ]);
    }

    public function test_will_fail_is_student_to_be_deleted_is_not_found()
    {

        $response = $this->json('DELETE', 'api/students/-1');

        $response->assertStatus(404);
    }

    public function test_a_student_can_be_deleted()
    {

        $response = $this->json('DELETE', "api/students/{$this->student->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('students', $this->student->toArray());
    }

    public function test_required_fields()
    {

        $response = $this->json('POST', 'api/students', [
            'email' => 'andres@mail.com',
            'direccion' => 'Colapiche 183'
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.apellido', ["El campo apellido es requerido"])
            ->assertJsonPath('errors.nombre', ["El campo nombre es requerido"])
            ->assertJsonPath('errors.dni', ["El campo dni es requerido"])
            ->assertJsonPath('errors.telefono', ["El campo telefono es requerido"]);
    }

    public function test_email_is_valid()
    {

        $response = $this->json('POST', 'api/students', [
            'apellido' => 'Martinez',
            'nombre' => 'Andres',
            'dni' => 31794897,
            'telefono' => '2920-542448',
            'email' => 'andres-mail.com',
            'direccion' => 'Colapiche 183'
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.email', ['El campo email debe ser valido']);
    }

    public function test_direccion_is_min_length_of_5()
    {

        $response = $this->json('POST', 'api/students', [
            'apellido' => 'Martinez',
            'nombre' => 'Andres',
            'dni' => 31794897,
            'telefono' => '2920-542448',
            'email' => 'andres@mail.com',
            'direccion' => 'Cola'
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.direccion', ['El campo dirección no puede contener un minimo de 5 caracteres']);
    }

    public function test_direccion_is_max_length_of_50()
    {

        $response = $this->json('POST', 'api/students', [
            'apellido' => 'Martinez',
            'nombre' => 'Andres',
            'dni' => 31794897,
            'telefono' => '2920-542448',
            'email' => 'andres@mail.com',
            'direccion' => 'Colapiche 183 Viedma Rio Negro, Barrio Don Bosco Al lado de la cancha de villa congreso paralelo a ruta 1'
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.direccion', ['El campo dirección no puede contener un maximo de 50 caracteres']);
    }
}
