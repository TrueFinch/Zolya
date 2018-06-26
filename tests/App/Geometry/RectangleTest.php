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

    public function testGetPc()
    {

    }

    public function testGetPd()
    {

    }

    public function testSetPd()
    {

    }

    public function testBelong()
    {

    }

    public function testGetArea()
    {

    }

    public function testSetPa()
    {

    }

    public function testIntersect()
    {

    }

    public function testGetPb()
    {

    }

    public function testSetPc()
    {

    }

    public function testGetPerimeter()
    {

    }

    public function testSetPb()
    {

    }

    public function testGetName()
    {

    }

    public function testGetPa()
    {

    }

    public function testSetName()
    {

    }
}
