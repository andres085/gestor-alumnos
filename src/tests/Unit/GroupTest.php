<?php

namespace Tests\Unit;

use App\Models\Group;
use App\Models\Student;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GroupTest extends TestCase
{

    use DatabaseMigrations;

    public function test_a_group_has_many_students()
    {
        $group = Group::factory()->create();

        $student1 = Student::factory()->create([
            'group_id' => $group->id
        ]);
        $student2 = Student::factory()->create([
            'group_id' => $group->id
        ]);
        $student3 = Student::factory()->create([
            'group_id' => $group->id
        ]);

        $this->assertTrue($group->students->contains($student1));
        $this->assertTrue($group->students->contains($student2));
        $this->assertTrue($group->students->contains($student3));
        $this->assertEquals(3, $group->students->count());
    }
}
