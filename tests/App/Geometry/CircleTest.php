<?php
/**
 * Created by PhpStorm.
 * User: truefinch
 * Date: 16.06.18
 * Time: 12:05
 */

namespace AppTest\App\Geometry;

use App\Geometry\Circle;
use App\Geometry\Line;
use App\Geometry\Point;
use App\Geometry\Rectangle;
use App\Geometry\ShapeInterface;
use PHPUnit\Framework\TestCase;

class CircleTest extends TestCase
{
    public function belongDataProvider()
    {
        return [
            [new Circle(new Point(0, 0), 2), new Point(1.2, 1.6), true],
            [new Circle(new Point(0, 0), 3), new Point(1, 1), false],
            [new Circle(new Point(0, 0), 2), new Point(0, 2), true],
            [new Circle(new Point(0, 0), 2), new Point(0, 0), false],
            [new Circle(new Point(0, 0), 2), new Point(42, 42), false],
            [new Circle(new Point(0, 0), 2), new Point(2, 0), true],
        ];
    }

    /**
     * @dataProvider belongDataProvider
     * @param $circle
     * @param $point
     * @param $expected
     */
    public function testBelong(Circle $circle, Point $point, bool $expected)
    {
        $this->assertEquals($expected, $circle->belong($point));
    }

    public function testGetName()
    {
        $circle = new Circle(new Point(0, 0), 0);
        $this->assertEquals('Circle', $circle->getName());
    }

    public function intersectDataProvider()
    {
        return [
            [
                new Circle(new Point(0, 0), 2), /**circle*/
                new Rectangle(new Point(-8, -2), /**rect*/
                    new Point(-8, 2),
                    new Point(0, 2),
                    new Point(0, -2)),
                [new Point(0, 2), new Point(0, -2)]/**expected*/
            ],
            [
                new Circle(new Point(0, 0), 2), /**circle*/
                new Rectangle(new Point(-8, -2), /**rect*/
                    new Point(-8, 2),
                    new Point(8, 2),
                    new Point(8, -2)),
                [new Point(0, 2), new Point(0, -2)]/**expected*/
            ],
            [
                new Circle(new Point(0, 0), 2), /**circle*/
                new Line(new Point(0, 2), new Point(2, 0)), /**Line*/
                [new Point(2, 0), new Point(0, 2)]/**expected*/
            ],
            [
                new Circle(new Point(0, 0), 2), /**circle*/
                new Line(new Point(0, 2), new Point(0, 42)), /**Line*/
                [new Point(0, 2)]/**expected*/
            ],
            [
                new Circle(new Point(0, 0), 2), /**circle*/
                new Circle(new Point(0, 0), 1), /**Circle*/
                []/**expected*/
            ],
            [
                new Circle(new Point(0, 0), 2), /**circle*/
                new Circle(new Point(0, 0), 2), /**circle*/
                [new Point(2, 0), new Point(-2, 0), new Point(0, 2)]/**expected*/
            ],
            [
                new Circle(new Point(4, 5), 3), /**circle*/
                new Circle(new Point(4, 5), 3), /**circle*/
                [new Point(7, 5), new Point(1, 5), new Point(4, 8)]/**expected*/
            ],
            [
                new Circle(new Point(0, 0), 2), /**circle*/
                new Circle(new Point(0, 1), 1), /**circle*/
                [new Point(0, 2)]/**expected*/
            ],
            [
                new Circle(new Point(0, 0), 3), /**circle*/
                new Circle(new Point(0, 1), 1), /**circle*/
                []/**expected*/
            ]
        ];
    }

    /**
     * @dataProvider intersectDataProvider
     * @param Circle $circle
     * @param ShapeInterface $shape
     * @param array $expected
     */
    public function testIntersect(Circle $circle, ShapeInterface $shape, array $expected)
    {
        $points = $circle->intersect($shape);
        $this->assertEquals(count($expected), count($points));
        for ($i = 0; $i < count($points); ++$i) {
            $this->assertEquals($expected[$i], $points[$i]);
        }
    }

    public function setRadiusDataProvider()
    {
        return [
          [new Circle(new Point(0, 0), 2), 2, true, 2],
          [new Circle(new Point(0, 0), 2), -2, false, 2],
          [new Circle(new Point(0, 0), 2), 3, true, 3],
          [new Circle(new Point(0, 0), 2), -3, false, 2],
          [new Circle(new Point(0, 0), 2), 125, true, 125],
          [new Circle(new Point(0, 0), 2), 0, true, 0],
          [new Circle(new Point(0, 0), 2), 4, true, 4]
        ];
    }

    /**
     * @dataProvider setRadiusDataProvider
     * @param Circle $circle
     * @param float $new_radius
     * @param bool $result
     * @param float $expected_radius
     */
    public function testGetSetRadius(Circle $circle, float $new_radius, bool $result, float $expected_radius)
    {
        $this->assertEquals($result, $circle->setRadius($new_radius));
        $this->assertEquals($expected_radius, $circle->getRadius());
    }

    public function setCenterDataProvider()
    {
        return [
            [new Circle(new Point(0, 0), 2), new Point(-1,-1)],
            [new Circle(new Point(0, 0), 2), new Point(-1,1)],
            [new Circle(new Point(0, 0), 2), new Point(1,-1)],
            [new Circle(new Point(0, 0), 2), new Point(1,1)]
        ];
    }

    /**
     * @dataProvider setCenterDataProvider
     * @param Circle $circle
     * @param Point $new_center
     */
    public function testSetCenter(Circle $circle, Point $new_center)
    {
        $circle->setCenter($new_center);
        $this->assertEquals($new_center->getX(), $circle->getCenter()->getX());
        $this->assertEquals($new_center->getY(), $circle->getCenter()->getY());

    }

    public function getPerimeterDataProvider()
    {
        return [
            [new Circle(new Point(0, 0), 2), 2 * pi() * 2],
            [new Circle(new Point(0, 0), 0), 2 * pi() * 0],
            [new Circle(new Point(0, 0), 1), 2 * pi() * 1],
            [new Circle(new Point(0, 0), 42), 2 * pi() * 42]
        ];
    }

    /**
     * @dataProvider getPerimeterDataProvider
     * @param Circle $circle
     * @param float $perimeter
     */
    public function testGetPerimeter(Circle $circle, float $perimeter)
    {
        $this->assertEquals($perimeter, $circle->getPerimeter());
    }

    public function getAreaDataProvider()
    {
        return [
            [new Circle(new Point(0, 0), 2), pi() * 2 * 2],
            [new Circle(new Point(0, 0), 0), pi() * 0 * 0],
            [new Circle(new Point(0, 0), 1), pi() * 1 * 1],
            [new Circle(new Point(0, 0), 42),pi() * 42 * 42]
        ];
    }

    /**
     * @dataProvider getAreaDataProvider
     * @param Circle $circle
     * @param float $area
     */
    public function testGetArea(Circle $circle, float $area)
    {
        $this->assertEquals($area, $circle->getArea());
    }
}
