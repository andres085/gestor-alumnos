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

    public function test_can_create_a_group()
    {
        $group = Group::factory()->create();

        $response = $this->json('POST', '/api/group-students', $group->toArray());

        $response->assertStatus(201);
        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'numero' => $group->numero
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
        $group = Group::factory()->create();

        $response = $this->json('GET', "/api/group-students/{$group->id}");

        $response->assertStatus(200)->assertJson([
            'numero' => $group->numero
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
        $response = $this->json('PUT', "/api/group-students/-1");

        $response->assertStatus(404);
    }

    public function test_can_delete_a_group()
    {
        $group = Group::factory()->create();

        $response = $this->json('DELETE', "/api/group-students/{$group->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('groups', $group->toArray());
    }

    public function test_error_404_if_group_to_delete_not_found()
    {
        $response = $this->json('DELETE', "/api/group-students/-1");

        $response->assertStatus(404);
    }

    public function test_number_is_required()
    {
    }

    public function test_rotation_is_required()
    {
    }
}
