<?php

namespace Tests\Feature\Http\Controller\Api;

use Tests\TestCase;
use App\Models\Group;
use App\Models\Rotation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GroupStudentsControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->group = Group::factory()->create();
    }

    public function test_can_create_a_group()
    {
        $response = $this->json('POST', '/api/group-students', $this->group->toArray());

        $response->assertStatus(201);
        $this->assertDatabaseHas('groups', [
            'id' => $this->group->id,
            'numero' => $this->group->numero
        ]);
    }

    // public function test_can_list_all_groups_from_a_rotation()
    // {
    //     $rotation = Rotation::factory()->create();
    //     $group1 = Group::factory()->create([
    //         'rotation_id' => $rotation->id
    //     ]);
    //     $group2 = Group::factory()->create([
    //         'rotation_id' => $rotation->id
    //     ]);
    // }

    public function test_can_show_a_group_and_the_students_in_it()
    {
        $response = $this->json('GET', "/api/group-students/{$this->group->id}");

        $response->assertStatus(200)->assertJson([
            'numero' => $this->group->numero
        ]);
    }

    public function test_can_update_a_group()
    {
        $group = Group::factory()->create([
            'numero' => 2,
        ]);

        $response = $this->json('PUT', "/api/group-students/{$group->id}", $group->toArray());

        $response->assertStatus(200)->assertJson([
            'numero' => $group->numero
        ]);
    }

    public function test_error_404_if_group_to_update_not_found()
    {
        $response = $this->json('PUT', "/api/group-students/-1", [
            'numero' => 1,
            'rotation_id' => 1
        ]);

        $response->assertStatus(404);
    }

    public function test_can_delete_a_group()
    {
        $response = $this->json('DELETE', "/api/group-students/{$this->group->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('groups', $this->group->toArray());
    }

    public function test_error_404_if_group_to_delete_not_found()
    {
        $response = $this->json('DELETE', "/api/group-students/-1");

        $response->assertStatus(404);
    }

    public function test_number_is_required_for_store()
    {

        $response = $this->json('POST', '/api/group-students', [
            'rotation_id' => 1
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.numero', ["El campo número es requerido"]);
    }

    public function test_rotation_is_required_for_store()
    {
        $response = $this->json('POST', '/api/group-students', [
            'numero' => 1
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.rotation_id', ["El campo rotación es requerido"]);
    }

    public function test_number_is_required_for_update()
    {

        $response = $this->json('PUT', '/api/group-students/1', [
            'rotation_id' => 1
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.numero', ["El campo número es requerido"]);
    }

    public function test_rotation_is_required_for_update()
    {
        $response = $this->json('PUT', '/api/group-students/1', [
            'numero' => 1
        ]);

        $response->assertStatus(422)->assertJsonPath('errors.rotation_id', ["El campo rotación es requerido"]);
    }
}
