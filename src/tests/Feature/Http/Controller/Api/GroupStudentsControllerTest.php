<?php

namespace Tests\Feature\Http\Controller\Api;

use Tests\TestCase;
use App\Models\Group;
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
    }
}
