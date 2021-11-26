<?php

namespace Tests\Feature\Http\Controller\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StudentControllerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    public function can_create_a_student()
    {

        $this->withoutExceptionHandling();

        $response = $this->json('POST', '/api/students', [
            'apellido' => 'Martinez',
            'nombre' => 'Andrés',
            'dni' => 31794897,
            'telefono' => '2920-542448',
            'email' => 'andresm.webdev@gmail.com',
            'direccion' => 'Colapiche 183'
        ]);

        $response->assertStatus(201);
    }
}
