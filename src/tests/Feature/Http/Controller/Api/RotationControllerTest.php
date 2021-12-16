<?php

namespace Tests\Feature\Http\Controller\Api;

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

        $response = $this->post('api/rotations', $rotation->toArray());

        $response->assertJsonStructure(['id', 'numero', 'fecha', 'observaciones'])->assertStatus(201);

        $this->assertDatabaseHas('rotations', [
            'numero' => $rotation->numero,
            'fecha' => $rotation->fecha
        ]);
    
    }

}