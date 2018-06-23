<?php

namespace AppTest\Geometry;

use App\Geometry\Circle;
use App\Geometry\Line;
use App\Geometry\Point;
use App\Geometry\Rectangle;
use PHPUnit\Framework\TestCase;

class PointTest extends TestCase
{
    public function testGetDistance()
    {
        $p1 = new Point(3, 4);
        $p2 = new Point(0, 0);
        $this->assertEquals(5, $p1->distance($p2));
    }
}