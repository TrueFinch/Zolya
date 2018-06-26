<?php
/**
 * Created by PhpStorm.
 * User: truefinch
 * Date: 07.06.18
 * Time: 22:32
 */

namespace App\Geometry;

/**
 * Class Line
 * @package App\Geometry
 */
class Line implements ShapeInterface
{
    /**
     * Name of class
     */
    private const NAME = 'Line';

    private $utils;

    /**
     * Boundaries of a segment
     * @var Point
     */
    private $pa_, $pb_;

    /**
     * Parameters of the line equation "Ax + By + C = 0"
     * @var float
     */
    private $a_, $b_, $c_;

    /**
     * Line constructor.
     * @param Point $pa_
     * @param Point $pb_
     */
    public function __construct(Point $pa_, Point $pb_)
    {
        $this->utils = new GeometryUtils();
        $this->pa_ = $pa_;
        $this->pb_ = $pb_;
        $this->recalculateParameters();
    }

    /**
     * Returns name of the shape
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * Line does not have area, so returns -1
     * @return float
     */
    public function getArea(): float
    {
        return -1;
    }

    /**
     * Returns the line length
     * @return float
     */
    public function getPerimeter(): float
    {
        return $this->pa_->distance($this->pb_);
    }

    /**
     * Literally same method as getPerimeter
     * @return float
     */
    public function length()
    {
        return $this->getPerimeter();
    }

    /**
     * Returns the point A
     * @return Point
     */
    public function getPa(): Point
    {
        return $this->pa_;
    }

    /**
     * Sets the point A
     * @param Point $point
     */
    public function setPa(Point $point): void
    {
        $this->pa_ = $point;
        $this->recalculateParameters();
    }

    /**
     * Returns the point B
     * @return Point
     */
    public function getPb(): Point
    {
        return $this->pb_;
    }

    /**
     * Sets the point B
     * @param Point $point
     */
    public function setPb(Point $point): void
    {
        $this->pb_ = $point;
        $this->recalculateParameters();
    }

    /**
     * Returns parameters of the line equation
     * @return array
     */
    public function getParameters(): array
    {
        return array($this->a_, $this->b_, $this->c_);
    }

    /**
     * Recalculate parameters on changing point's coordinate
     * It returns nothing
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

        $zn1 = $this->utils->det($a1, $b1, $a2, $b2);
        $zn2 = $this->utils->det($a1, $c1, $a2, $c2);
        $zn3 = $this->utils->det($b1, $c1, $b2, $c2);

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
            $x = ($zn3) / $zn1;
            $y = (-$zn2) / $zn1;
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
        return $circle->intersect($this);
    }

    /**
     * @param $shape
     * @return array
     */
    public function intersect(ShapeInterface $shape): array
    {
        /**
         * @var array of Points
         */
        $result = array();
        switch ($shape->getName()) {
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

    /**
     * A scalar product
     * @param Line $other
     * @return float
     */
    public function dotProduct(Line $other): float
    {
        return ($this->getPb()->getX() - $this->getPa()->getX()) * ($other->getPb()->getX() - $other->getPa()->getX()) +
            ($this->getPb()->getY() - $this->getPa()->getY()) * ($other->getPb()->getY() - $other->getPa()->getY());
    }

    /**
     * An angle between this line and other
     * @param Line $other
     * @return float
     */
    public function getAngle(Line $other): float
    {
        return ($this->dotProduct($other) == 0) ? (pi() / 2) : (acos($this->dotProduct($other) / sqrt($this->dotProduct($this) * $other->dotProduct($other))));
    }
}