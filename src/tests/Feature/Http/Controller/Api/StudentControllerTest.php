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

        $response = $this->postJson(route('students.store'), $student->toArray());

        $response->assertJsonStructure(['id', 'apellido', 'nombre', 'dni', 'telefono', 'email', 'direccion'])->assertStatus(201);

        $this->assertDatabaseHas('students', [
            'dni' => $student->dni
        ]);
    }

    public function test_error_404_if_student_not_found()
    {

        $response = $this->getJson('students.show');

        $response->assertStatus(404);
    }

    public function test_can_return_a_student()
    {

        $student = Student::factory()->create();

        $response = $this->getJson(route('students.show', $student->id));

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

        $response = $this->putJson(route('students.update', -1));

        $response->assertStatus(404);
    }

    public function test_can_update_a_student()
    {

        $this->withoutExceptionHandling();

        $student = Student::factory()->create();

        $response = $this->putJson(route('students.update', $student->id), [
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

        $response = $this->deleteJson(route('students.destroy', -1));

        $response->assertStatus(404);
    }

    public function test_a_student_can_be_deleted()
    {

        $student = Student::factory()->create();

        $response = $this->deleteJson(route('students.destroy', $student->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('students', $student->toArray());
    }

    public function test_required_fields()
    {

        $response = $this->postJson(route('students.store'), [
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

        $response = $this->postJson(route('students.store'), [
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

        $response = $this->postJson(route('students.store'), [
            'apellido' => 'Martinez',
            'nombre' => 'Andres',
            'dni' => 31794897,
            'telefono' => '2920-542448',
            'email' => 'andres@mail.com',
            'direccion' => 'Cola'
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.direccion', ['El campo dirección no puede contener un minimo de 5 caracteres']);
    }

    public function test_direccion_is_max_length_of_30()
    {

        $response = $this->postJson(route('students.store'), [
            'apellido' => 'Martinez',
            'nombre' => 'Andres',
            'dni' => 31794897,
            'telefono' => '2920-542448',
            'email' => 'andres@mail.com',
            'direccion' => 'Colapiche 183 Viedma Rio Negro, Barrio Don Bosco'
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.direccion', ['El campo dirección no puede contener un maximo de 30 caracteres']);
    }
}
