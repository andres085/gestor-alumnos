<?php

namespace Tests\Feature\Http\Controller\Api;

use Carbon\Carbon;
use Tests\TestCase;
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

        $response = $this->postJson(route('rotations.store'), $rotation->toArray());

        $response->assertJsonStructure(['id', 'numero', 'fecha', 'observaciones'])->assertStatus(201);

        $this->assertDatabaseHas('rotations', [
            'numero' => $rotation->numero,
            'fecha' => $rotation->fecha
        ]);
    }

    public function test_error_404_if_rotation_not_found()
    {

        $response = $this->getJson('api/rotations/-1');

        $response->assertStatus(404);
    }

    public function test_can_return_a_rotation()
    {

        $rotation = Rotation::factory()->create();

        $response = $this->getJson(route('rotations.show', $rotation->id));

        $response->assertStatus(200)->assertJson($rotation->toArray());
    }

    public function test_can_update_a_rotation()
    {
        $rotation = Rotation::factory()->create([
            'observaciones' => 'Este es un texto de prueba'
        ]);

        $response = $this->putJson(route('rotations.update', $rotation->id), $rotation->toArray());

        $response->assertStatus(200)->assertJson([
            'observaciones' => $rotation->observaciones
        ]);
    }

    public function test_delete_a_rotation()
    {
        $rotation = Rotation::factory()->create();

        $response = $this->deleteJson(route('rotations.destroy', $rotation->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('rotations', $rotation->toArray());
    }
}
