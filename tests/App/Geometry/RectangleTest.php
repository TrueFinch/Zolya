<?php
/**
 * Created by PhpStorm.
 * User: truefinch
 * Date: 16.06.18
 * Time: 12:04
 */

namespace AppTest\App\Geometry;

use App\Geometry\Rectangle;
use App\Geometry\Point;
use App\Geometry\Circle;
use App\Geometry\Line;
use App\Geometry\ShapeInterface;
use PHPUnit\Framework\TestCase;

class RectangleTest extends TestCase
{
    public function gettersSettersDataProvider()
    {
        return [
            [new Rectangle(new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)), // rectangle
                [new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)], //new points of rectangle
                false], //is rectangle invalid

            [new Rectangle(new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)), // rectangle
                [new Point(1, 1), new Point(1, 2), new Point(2, 2), new Point(2, 1)], //new points of rectangle
                false], //is rectangle invalid

            [new Rectangle(new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)), // rectangle
                [new Point(-2, 1), new Point(0, 3), new Point(4, -1), new Point(2, -3)], //new points of rectangle
                false], //is rectangle invalid

            [new Rectangle(new Point(-2, 1), new Point(0, 3), new Point(4, -1), new Point(2, -3)), // rectangle
                [new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)], //new points of rectangle
                false], //is rectangle invalid

            [new Rectangle(new Point(-2, 1), new Point(0, 3), new Point(4, -1), new Point(2, -3)), // rectangle
                [new Point(-2, 1), new Point(0, 3), new Point(4, -1), new Point(2, -3)], //new points of rectangle
                false], //is rectangle invalid

            [new Rectangle(new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)), // rectangle
                [new Point(0, 0), new Point(0, 0), new Point(0, 0), new Point(0, 0)], //new points of rectangle
                true], //is rectangle invalid

            [new Rectangle(new Point(0, 0), new Point(0, 0), new Point(0, 0), new Point(0, 0)), // rectangle
                [new Point(0, 0), new Point(0, 0), new Point(0, 0), new Point(0, 0)], //new points of rectangle
                true], //is rectangle invalid
        ];
    }

    /**
     * @dataProvider gettersSettersDataProvider
     * @param Rectangle $rect
     * @param array $points
     * @param bool $is_invalid_
     */
    public function testPointsGettersSetters(Rectangle $rect, array $points, bool $is_invalid_)
    {
        $rect->setPa($points[0]);
        $rect->setPb($points[1]);
        $rect->setPc($points[2]);
        $rect->setPd($points[3]);
        $this->assertEquals($is_invalid_, $rect->isInvalid());
        $this->assertEquals($points[0], $rect->getPa());
        $this->assertEquals($points[1], $rect->getPb());
        $this->assertEquals($points[2], $rect->getPc());
        $this->assertEquals($points[3], $rect->getPd());
    }

    public function belongDataProvider()
    {
        return [
            [new Rectangle(new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)), // rectangle
                new Point(0, 0), true], // point and answer belong or not

            [new Rectangle(new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)), // rectangle
                new Point(0, 1), true], // point and answer belong or not

            [new Rectangle(new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)), // rectangle
                new Point(1, 1), true], // point and answer belong or not

            [new Rectangle(new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)), // rectangle
                new Point(1, 0), true], // point and answer belong or not

            [new Rectangle(new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)), // rectangle
                new Point(0.1, 0.1), false], // point and answer belong or not

            [new Rectangle(new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)), // rectangle
                new Point(-1, 0), false], // point and answer belong or not

            [new Rectangle(new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)), // rectangle
                new Point(0.5, 0.5), false], // point and answer belong or not

            [new Rectangle(new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)), // rectangle
                new Point(42, 42), false], // point and answer belong or not

            [new Rectangle(new Point(0, 0), new Point(0, 0), new Point(0, 0), new Point(0, 0)), // rectangle
                new Point(42, 42), false] // point and answer belong or not
        ];
    }

    /**
     * @dataProvider belongDataProvider
     * @param Rectangle $rect
     * @param Point $point
     * @param bool $result
     */
    public function testBelong(Rectangle $rect, Point $point, $result)
    {
        $this->assertEquals($result, $rect->belong($point));
    }

    public function getAreaDataProvider()
    {
        return [
            [new Rectangle(new Point(0, 0), new Point(0, 1), new Point(1, 1), new Point(1, 0)), // rectangle
                1], //expected area of the rectangle

            [new Rectangle(new Point(0, 0), new Point(0, 2), new Point(1, 2), new Point(1, 0)), // rectangle
                2], //expected area of the rectangle

            [new Rectangle(new Point(0, 0), new Point(0, 0), new Point(0, 0), new Point(1, 0)), // rectangle
                -1], //expected area of the rectangle

            [new Rectangle(new Point(-2, 1), new Point(0, 3), new Point(4, -1), new Point(2, -3)), // rectangle
                16], //expected area of the rectangle

            [new Rectangle(new Point(1, 0), new Point(0, 0), new Point(0, 1), new Point(1, 1)), // rectangle
                1], //expected area of the rectangle

            [new Rectangle(new Point(0, 1), new Point(0, 0), new Point(1, 1), new Point(1, 0)), // rectangle
                -1], //expected area of the rectangle
        ];
    }

    /**
     * @dataProvider getAreaDataProvider
     * @param Rectangle $rectangle
     * @param float $expected_area
     */
    public function testGetArea(Rectangle $rectangle, $expected_area)
    {
        $this->assertEquals($expected_area, $rectangle->getArea());
    }

    public function intersectDataProvider()
    {
        return [
            [
                new Rectangle(new Point(0, 2), /**rect*/
                    new Point(0, 3),
                    new Point(3, 3),
                    new Point(3, 2)),
                new Circle(new Point(0, 0), 2), /**circle*/
                [new Point(0, 2)]/**expected*/
            ],
            [
                new Rectangle(new Point(-8, -2), /**rect*/
                    new Point(-8, 2),
                    new Point(0, 2),
                    new Point(0, -2)),
                new Circle(new Point(0, 0), 2), /**circle*/
                [new Point(0, 2), new Point(0, -2)]/**expected*/
            ],
            [
                new Rectangle(new Point(-8, -2), /**rect*/
                    new Point(-8, 2),
                    new Point(8, 2),
                    new Point(8, -2)),
                new Circle(new Point(0, 0), 2), /**circle*/
                [new Point(0, 2), new Point(0, -2)]/**expected*/
            ],
            [
                new Rectangle(new Point(-2, 2),
                    new Point(-2, 7),
                    new Point(11, 7),
                    new Point(11, 2)),
                new Line(new Point(2, 3), new Point(2, 6)),
                []
            ],
            [
                new Rectangle(new Point(-2, 2),
                    new Point(-2, 7),
                    new Point(11, 7),
                    new Point(11, 2)),
                new Line(new Point(1, 1), new Point(5, 5)),
                [new Point(2, 2)]
            ],
            [
                new Rectangle(new Point(-2, 2),
                    new Point(-2, 7),
                    new Point(11, 7),
                    new Point(11, 2)),
                new Line(new Point(4, 2), new Point(4, 6)),
                [new Point(4, 2)]
            ],
            [
                new Rectangle(new Point(0, 0),
                    new Point(0, 1),
                    new Point(1, 1),
                    new Point(1, 0)),
                new Rectangle(new Point(0.5, 0.5),
                    new Point(0.5, 2.5),
                    new Point(1.5, 2.5),
                    new Point(1.5, 0.5)),
                [new Point(0.5, 1), new Point(1, 0.5)]
            ],
            [
                new Rectangle(new Point(-2, 1),
                    new Point(0, 3),
                    new Point(4, -1),
                    new Point(2, -3)),
                new Rectangle(new Point(-2, -1),
                    new Point(-2, 0),
                    new Point(4, 0),
                    new Point(4, -1)),
                [new Point(3, 0), new Point(4, -1), new Point(-1, 0), new Point(0, -1)]
            ]
        ];
    }

    /**
     * @dataProvider intersectDataProvider
     * @param Rectangle $rect
     * @param ShapeInterface $shape
     * @param array $expected
     */
    public function testIntersect(Rectangle $rect, ShapeInterface $shape, array $expected)
    {
        $points = $rect->intersect($shape);
        $this->assertEquals(count($expected), count($points));
        for ($i = 0; $i < count($points); ++$i) {
            $this->assertEquals($expected[$i], $points[$i]);
        }
    }

    public function getPerimeterDataProvider()
    {
        return [
            [
                new Rectangle(new Point(-2, -1), //rectangle
                    new Point(-2, 0),
                    new Point(4, 0),
                    new Point(4, -1)),
                14 // expected perimeter
            ],
            [
                new Rectangle(new Point(0, 0), //rectangle
                    new Point(0, 0),
                    new Point(0, 0),
                    new Point(0, 0)),
                -1 // expected perimeter
            ]
        ];
    }

    /**
     * @dataProvider getPerimeterDataProvider
     * @param Rectangle $rect
     * @param float $expected_perimeter
     */
    public function testGetPerimeter(Rectangle $rect, float $expected_perimeter)
    {
        $this->assertEquals($expected_perimeter, $rect->getPerimeter());
    }

    public function getNameDataProvider()
    {
        return [
            [
                new Rectangle(new Point(-2, -1), //rectangle
                    new Point(-2, 0),
                    new Point(4, 0),
                    new Point(4, -1)),
                'Rectangle' // expected perimeter
            ],
            [
                new Rectangle(new Point(0, 0), //rectangle
                    new Point(0, 0),
                    new Point(0, 0),
                    new Point(0, 0)),
                'wabulabudabdab' // expected perimeter
            ]
        ];
    }

    /**
     * @dataProvider getNameDataProvider
     * @param Rectangle $rect
     * @param string $expected_name
     */
    public function testGetName(Rectangle $rect, string $expected_name)
    {
        $this->assertEquals($expected_name, $rect->getName());
    }
}
