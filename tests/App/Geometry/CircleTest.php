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

    public function testSetRadius()
    {

    }

    public function testSetName()
    {

    }

    public function testIntersectCircle()
    {

    }

    public function testSetCenter()
    {

    }

    public function testGetPerimeter()
    {

    }

    public function testGetCenter()
    {

    }

    public function testIntersectLine()
    {

    }

    public function testGetRadius()
    {

    }

    public function testGetArea()
    {

    }
}
