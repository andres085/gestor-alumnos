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

    public function test_can_create_a_rotation()
    {

        $rotation = Rotation::factory()->create();

        $response = $this->json('POST', 'api/rotations', $rotation->toArray());

        $response->assertJsonStructure(['id', 'numero', 'fecha', 'observaciones'])->assertStatus(201);

        $this->assertDatabaseHas('rotations', [
            'numero' => $rotation->numero,
            'fecha' => $rotation->fecha,
            'observaciones' => $rotation->observaciones,
        ]);
    }

    public function test_can_get_all_rotations()
    {
        $this->withoutExceptionHandling();

        $response = $this->json('GET', 'api/rotations');

        $response->assertStatus(200);
    }

    public function test_error_404_if_rotation_not_found()
    {

        $response = $this->json('GET', 'api/rotations/-1');

        $response->assertStatus(404);
    }

    public function test_can_return_a_rotation()
    {

        $rotation = Rotation::factory()->create();

        $response = $this->json('GET', "api/rotations/{$rotation->id}");

        $response->assertStatus(200)->assertJson($rotation->toArray());
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
        $rotation = Rotation::factory()->create();

        $response = $this->json('DELETE', "api/rotations/{$rotation->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('rotations', $rotation->toArray());
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
