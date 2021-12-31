<?php

namespace Tests\Unit;

use Carbon\Carbon;
use App\Models\Rotation;
use PHPUnit\Framework\TestCase;

class RotationTest extends TestCase
{

    public function test_format_fecha_to_day_month_year()
    {
        $rotation = Rotation::factory()->make([
            'fecha' => Carbon::parse('2021-12-01'),
        ]);

        $this->assertEquals('01/12/2021', $rotation->formatted_date);
    }
}