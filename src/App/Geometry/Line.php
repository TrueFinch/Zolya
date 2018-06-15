<?php
/**
 * Created by PhpStorm.
 * User: truefinch
 * Date: 07.06.18
 * Time: 22:32
 */

namespace App\Geometry;

include 'ShapeInterface.php';

/**
 * Class Line
 * @package App\Geometry
 */
class Line implements ShapeInterface
{
    /**
     * @var Point boundaries of a segment
     */
    private $pa_, $pb_;

    /**
     * Parameters of line equation
     * @var float
     */
    private $a_, $b_, $c_;

    /**
     * @var string $name_ name of class? idk
     */
    private $name_;

    /**
     * Line constructor.
     * @param Point $pa_
     * @param Point $pb_
     */
    public function __construct(Point $pa_, Point $pb_)
    {
        $this->pa_ = $pa_;
        $this->pb_ = $pb_;
        $this->recalculateParameters();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name_;
    }

    /**
     * @return float
     */
    public function getArea(): float
    {
        return -1;
    }

    /**
     * @return float
     */
    public function getPerimeter(): float
    {
        return $this->pa_->distance($this->pb_);
    }

    /**
     * @return Point
     */
    public function getPa(): Point
    {
        return $this->pa_;
    }

    /**
     * @param Point $point
     */
    public function setPa(Point $point): void
    {
        $this->pa_ = $point;
    }

    /**
     * @return Point
     */
    public function getPb(): Point
    {
        return $this->pb_;
    }

    /**
     * @param Point $point
     */
    public function setPb(Point $point): void
    {
        $this->pb_ = $point;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return array($this->a_, $this->b_, $this->c_);
    }

    /**
     *Recalculate parameters on changing point's coordinate
     */
    public function recalculateParameters(): void
    {
        $this->a_ = $this->pa_->getY() - $this->pb_->getY();
        $this->b_ = $this->pb_->getX() - $this->pa_->getX();
        $this->c_ = $this->pa_->getX() * $this->pb_->getY() - $this->pb_->getX() * $this->pa_->getY();
        if ($this->a_ < 0) {
            $this->a_ *= (-1);
            $this->b_ *= (-1);
            $this->c_ *= (-1);
        } elseif (($this->b_ < 0) and ($this->a_ == 0)) {
            $this->b_ *= (-1);
            $this->c_ *= (-1);
        }
    }

    /**
     * @param Point $point
     * @return bool
     */
    public function belong(Point $point): bool
    {
        /**
         * @var array $p An array of parameters of line $this
         */
        $p = $this->getParameters();
        /**
         * @var double parameters of $this line
         */
//        $a1 = $p[0];
//        $b1 = $p[1];
//        $c1 = $p[2];
        /**
         * @var double $x1 - x coordinate of point A
         * @var double $y1 - y coordinate of point A
         * @var double $x2 - y coordinate of point B
         * @var double $y2 - y coordinate of point B
         */
        $x1 = $this->getPa()->getX();
        $y1 = $this->getPa()->getY();
        $x2 = $this->getPb()->getX();
        $y2 = $this->getPb()->getY();

        if ($x2 > $x1) {
            $c = $x2;
            $x2 = $x1;
            $x1 = $c;
        }
        if ($y2 > $y1) {
            $c = $y2;
            $y2 = $y1;
            $y1 = $c;
        }

        return ((($point->getX() * $p[0] + $point->getY() * $p[1] + $p[2]) == 0)
            and ($x2 <= $point->getX()) and ($point->getX() <= $x1)
            and ($y2 <= $point->getY()) and ($point->getY() <= $y1));
    }

    /**
     * @param Line $line
     * @return array
     */
    private function intersectLine(Line $line): array
    {
        /**
         * Array of Points
         * @var array
         */
        $result = array();
        /**
         * Array of double
         * @var array
         */
        $p = $this->getParameters();
        /**
         * @var double parameters of $this line
         */
        $a1 = $p[0];
        $b1 = $p[1];
        $c1 = $p[2];
        /**
         * Array of double
         * @var array
         */
        $p = $line->getParameters();
        /**
         * @var double parameters of $line line
         */
        $a2 = $p[0];
        $b2 = $p[1];
        $c2 = $p[2];

        $zn1 = det($a1, $b1, $a2, $b2);
        $zn2 = det($a1, $c1, $a2, $c2);
        $zn3 = det($b1, $c1, $b2, $c2);

        if ($zn1 == 0) {
            if (($zn2 == 0) and ($zn3 == 0)) {
                if ($line->belong($this->getPa())) {
                    array_push($result, $this->getPa());
                }
                if ($line->belong($this->getPb())) {
                    array_push($result, $this->getPb());
                }
                if (count($result)) {
                    return $result;
                }
                if ($this->belong($line->getPa())) {
                    array_push($result, $this->getPa());
                }
                if ($this->belong($line->getPb())) {
                    array_push($result, $this->getPb());
                }

            }
        } else {
            /**
             * @var double
             */
            $x = (-$zn3) / $zn1;
            $y = ($zn2) / $zn1;
            $point = new Point($x, $y);
            if ($this->belong($point) and $line->belong($point)) {
                array_push($result, $point);
            }
        }
        return $result;
    }

    /**
     * @param Rectangle $rect
     * @return array
     */
    private function intersectRect(Rectangle $rect): array
    {
        /**
         * @var array Array of Points
         */
        $result = array();
        /**
         * Sides of rectangle rect
         * @var Line
         */
        $side_a = new Line($rect->getPa(), $rect->getPb());
        $side_b = new Line($rect->getPb(), $rect->getPc());
        $side_c = new Line($rect->getPc(), $rect->getPd());
        $side_d = new Line($rect->getPd(), $rect->getPa());

        $points = $this->intersectLine($side_a);
        $points = array_merge($points, $this->intersectLine($side_b));
        $points = array_merge($points, $this->intersectLine($side_c));
        $points = array_merge($points, $this->intersectLine($side_d));

        for ($i = 0; $i < count($points); ++$i) {
            if (array_search($points[$i], $result) == false) {
                array_push($result, $points[$i]);
            }
        }

        return $result;
    }

    /**
     * @param Circle $circle
     * @return array
     */
    private function intersectCircle(Circle $circle): array
    {
        $result = array();
        /**
         * Parameters of line
         * @var array
         */
        $v = $this->getParameters();
        $a = $v[0];
        $b = $v[1];
        $c = $v[2];
        /**
         * X coordinate of the circle's center
         * @var float
         */
        $p = $circle->getCenter()->getX();
        /**
         * Y coordinate of the circle's center
         * @var float
         */
        $q = $circle->getCenter()->getY();
        /**
         * Radius of the circle
         * @var float
         */
        $r = $circle->getRadius();
        /**
         * Distance from line to circle's center
         */
        $d = abs($a * $p + $b * $q + $c) / sqrt($a * $a + $b * $b);

        if ($d <= $r) {
            $p1 = new Point(42, 42);
            $p2 = new Point(42, 42);
            if ($b == 0) {
                $p1->setX((-1) * $c / $a);
                $p1->setY($q + sqrt(($r - $c / $a - $p) * ($r + $c / $a + $p)));
                $p2->setX((-1) * $c / $a);
                $p2->setY($q - sqrt(($r - $c / $a - $p) * ($r + $c / $a + $p)));
            } else {
                $k = $b * $b * $p - $a * ($b * $q + $c);
                $s = $a * $a + $b * $b;
                $t = $b * sqrt($r * $r * $s - pow($a * $p + $b * $q + $c, 2));
                $p1->setX(($k + $t) / $s);
                $p1->setY((-1) * ($a * $p1->getX() + $c) / $b);
                $p2->setX(($k - $t) / $s);
                $p2->setY((-1) * ($a * $p2->getX() + $c) / $b);
            }
            if ($d == $r) {
                if ($this->belong($p1)) {
                    array_push($result, $p1);
                }
            } elseif ($d < $r) {
                if ($this->belong($p1)) {
                    array_push($result, $p1);
                }
                if ($this->belong($p2)) {
                    array_push($result, $p2);
                }
            }
        }
        return $result;
    }


/**
 * @param $shape
 * @return array
 */
public
function intersect($shape): array
{
    /**
     * @var array of Points
     */
    $result = array();
    switch (gettype($shape)) {
        case "Line":
            $result = $this->intersectLine($shape);
            break;
        case "Rectangle":
            $result = $this->intersectRect($shape);
            break;
        case "Circle":
            $result = $this->intersectCircle($shape);
            break;
    }
    return $result;
}
}