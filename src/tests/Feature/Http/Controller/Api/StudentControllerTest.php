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

    public function test_required_fields()
    {
        
        $response = $this->postJson('/api/students', [
            'email' => 'andres@mail.com',
            'direccion' => 'Colapiche 183'
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.apellido', ["The apellido field is required."])
        ->assertJsonPath('errors.nombre', ["The nombre field is required."])
        ->assertJsonPath('errors.dni', ["The dni field is required."])
        ->assertJsonPath('errors.telefono', ["The telefono field is required."]);
        
    }

    public function test_email_is_valid()
    {

        $response = $this->postJson('/api/students', [
            'apellido' => 'Martinez',
            'nombre' => 'Andres',
            'dni' => 31794897,
            'telefono' => '2920-542448',
            'email' => 'andres-mail.com',
            'direccion' => 'Colapiche 183'
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.email', ['The email must be a valid email address.']);
    }

    public function test_direccion_is_min_length_of_5()
    {

        $response = $this->postJson('/api/students', [
            'apellido' => 'Martinez',
            'nombre' => 'Andres',
            'dni' => 31794897,
            'telefono' => '2920-542448',
            'email' => 'andres@mail.com',
            'direccion' => 'Cola'
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.direccion', ["The direccion must be at least 5  characters."]);

    }

    public function test_direccion_is_max_length_of_30()
    {

        $response = $this->postJson('/api/students', [
            'apellido' => 'Martinez',
            'nombre' => 'Andres',
            'dni' => 31794897,
            'telefono' => '2920-542448',
            'email' => 'andres@mail.com',
            'direccion' => 'Colapiche 183 Viedma Rio Negro, Barrio Don Bosco'
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.direccion', ["The direccion must not be greater than 30 characters."]);

    }

}
