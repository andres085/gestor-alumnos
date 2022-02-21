<?php

namespace Tests\Feature\Http\Controller\Api;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Group;
use App\Models\Rotation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RotationControllerTest extends TestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rotation = Rotation::factory()->create();
    }


    public function test_can_create_a_rotation()
    {
        $response = $this->json('POST', 'api/rotations', $this->rotation->toArray());

        $response->assertStatus(201)->assertJsonStructure(['id', 'numero', 'fecha', 'observaciones']);

        $this->assertDatabaseHas('rotations', [
            'numero' => $this->rotation->numero,
            'fecha' => $this->rotation->fecha,
            'observaciones' => $this->rotation->observaciones,
        ]);
    }

    public function test_can_get_all_rotations()
    {
        $response = $this->json('GET', 'api/rotations');

        $response->assertStatus(200)->assertJson([
            [
                'id' => $this->rotation->id,
            ]
        ]);
    }

    public function test_error_404_if_rotation_not_found()
    {

        $response = $this->json('GET', 'api/rotations/-1');

        $response->assertStatus(404);
    }

    public function test_can_return_a_rotation()
    {
        $response = $this->json('GET', "api/rotations/{$this->rotation->id}");

        $response->assertStatus(200)->assertJson($this->rotation->toArray());
    }

    public function test_can_update_a_rotation()
    {
        $rotation = Rotation::factory()->create([
            'observaciones' => 'Este es un texto de prueba'
        ]);

        $response = $this->json('PUT', "api/rotations/{$rotation->id}", $rotation->toArray());

        $response->assertStatus(200)->assertJson([
            'observaciones' => $rotation->observaciones
        ]);
    }

    public function test_delete_a_rotation()
    {
        $response = $this->json('DELETE', "api/rotations/{$this->rotation->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('rotations', $this->rotation->toArray());
    }

    public function test_fecha_field_is_required()
    {

        $response = $this->json('POST', 'api/rotations', [
            'numero' => 1,
            'observaciones' => 'Test rotation 123'
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.fecha', ["El campo fecha es requerido"]);
    }

    public function test_numero_field_is_required()
    {

        $response = $this->json('POST', 'api/rotations', [
            'fecha' => Carbon::now(),
            'observaciones' => 'Test rotation 123'
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.numero', ["El campo numero es requerido"]);
    }
}
