<?php
/**
 * Created by PhpStorm.
 * User: truefinch
 * Date: 16.06.18
 * Time: 12:03
 */

namespace AppTest\App\Geometry;

use App\Geometry\Line;
use App\Geometry\Circle;
use App\Geometry\Rectangle;
use App\Geometry\Point;
use PHPUnit\Framework\TestCase;

class LineTest extends TestCase
{
    public function testGetPa()
    {
        $line = new Line(new Point(3, 4), new Point(0, 0));
        $this->assertEquals(new Point(3, 4), $line->getPa());
    }

    public function testSetPa()
    {
        $line = new Line(new Point(0, 0), new Point(0, 0));
        $line->setPa(new Point(3, 4));
        $this->assertEquals(new Point(3, 4), $line->getPa());
    }

    public function testGetPb()
    {
        $line = new Line(new Point(3, 4), new Point(42, 42));
        $this->assertEquals(new Point(42, 42), $line->getPb());
    }

    public function testSetPb()
    {
        $line = new Line(new Point(0, 0), new Point(42, 42));
        $line->setPb(new Point(3, 4));
        $this->assertEquals(new Point(3, 4), $line->getPb());
    }

    public function testGetName()
    {
        $line = new Line(new Point(3, 4), new Point(0, 0));
        $this->assertEquals('Line', $line->getName());
    }

    public function testGetArea()
    {
        $line = new Line(new Point(3, 4), new Point(0, 0));
        $this->assertEquals(-1, $line->getArea());
    }

    public function testGetPerimeter()
    {
        $p0 = new Point(3, 4);
        $p1 = new Point(0, 0);
        $line = new Line($p0, $p1);
        $this->assertEquals(5, $line->getPerimeter());
        $p1->setX(6);
        $p1->setY(8);
        $this->assertEquals(5, $line->getPerimeter());
    }

    public function testGetParameters()
    {
        $line0 = new Line(new Point(3, 4), new Point(7, 15));
        $line1 = new Line(new Point(7, 15), new Point(3, 4));
        $param0 = $line0->getParameters();
        $param1 = $line1->getParameters();
        $expected_param = array(11, -4, -17);
        $this->assertEquals(count($expected_param), count($param0));
        $this->assertEquals(count($expected_param), count($param1));
        for ($i = 0; $i < count($param0); ++$i) {
            $this->assertEquals($param0[$i], $param1[$i]);
            $this->assertEquals($expected_param[$i], $param1[$i]);
        }
    }

    public function testRecalculateParameters()
    {
        $line = new Line(new Point(3, 4), new Point(7, 15));
        $param = $line->getParameters();
        $expected_param = array(11, -4, -17);
        $this->assertEquals(count($expected_param), count($param));
        for ($i = 0; $i < count($param); ++$i) {
            $this->assertEquals($expected_param[$i], $param[$i]);
        }
        $line->setPb(new Point(-27, 44));
        $param = $line->getParameters();
        $expected_param = array(40, 30, -240);
        $this->assertEquals(count($expected_param), count($param));
        for ($i = 0; $i < count($param); ++$i) {
            $this->assertEquals($expected_param[$i], $param[$i]);
        }
    }

    public function testBelong()
    {
        //TODO: add dataproviders
        $line = new Line(new Point(3, 4), new Point(7, 15));
        $p0 = new Point(0, 0);
        $p1 = new Point(7, 15);
        $this->assertTrue($line->belong($p1));
        $p3 = new Point(3, 4);
        $this->assertTrue($line->belong($p3));
    }

    public function testIntersect()
    {
        $line0 = new Line(new Point(1, 1), new Point(5, 5));
        $line1 = new Line(new Point(2, 3), new Point(2, 6));
        $line2 = new Line(new Point(4, 2), new Point(4, 6));

        $expected_points = array();
        $points = $line0->intersect($line1);
        $this->assertEquals(count($expected_points), count($points));

        array_push($expected_points, new Point(4, 4));
        $points = $line0->intersect($line2);
        $this->assertEquals(count($expected_points), count($points));
        for ($i = 0; $i < count($points); ++$i) {
            $this->assertEquals($expected_points[$i], $points[$i]);
        }

        $circle0 = new Circle(new Point(4, 0), 2);
        $expected_points = array(new Point(4, 2));
        $points = $line2->intersect($circle0);
        $this->assertEquals(count($expected_points), count($points));
        for ($i = 0; $i < count($points); ++$i) {
            $this->assertEquals($expected_points[$i], $points[$i]);
        }

        $expected_points = array();
        $points = $line1->intersect($circle0);
        $this->assertEquals(count($expected_points), count($points));
        for ($i = 0; $i < count($points); ++$i) {
            $this->assertEquals($expected_points[$i], $points[$i]);
        }

        $rect0 = new Rectangle(new Point(-2, 2), new Point(-2, 7),
            new Point(11, 7), new Point(11, 2));
        $expected_points = array();
        $points = $line1->intersect($rect0);
        $this->assertEquals(count($expected_points), count($points));
        for ($i = 0; $i < count($points); ++$i) {
            $this->assertEquals($expected_points[$i], $points[$i]);
        }

        $expected_points = array(new Point(2, 2));
        $points = $line0->intersect($rect0);
        $this->assertEquals(count($expected_points), count($points));
        for ($i = 0; $i < count($points); ++$i) {
            $this->assertEquals($expected_points[$i], $points[$i]);
        }

        $expected_points = array(new Point(4, 2));
        $points = $line2->intersect($rect0);
        $this->assertEquals(count($expected_points), count($points));
        for ($i = 0; $i < count($points); ++$i) {
            $this->assertEquals($expected_points[$i], $points[$i]);
        }
    }
}