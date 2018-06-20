<?php
/**
 * Created by PhpStorm.
 * User: truefinch
 * Date: 09.06.18
 * Time: 0:51
 */

namespace App\Geometry;


/**
 * Class Circle
 * @package App\Geometry
 */
class Circle implements ShapeInterface
{
    /**
     * Center of the circle
     * @var Point
     */
    private $center_;
    /**
     * Radius of the circle
     * @var double
     */
    private $radius_;

    /**
     * @return Point
     */

    /**
     * @var string $name_ name of class? idk
     */
    private $name_;

    /**
     * Circle constructor.
     * @param Point $center_
     * @param float $radius_
     */
    public function __construct(Point $center_, float $radius_)
    {
        $this->center_ = $center_;
        $this->radius_ = $radius_;
        $this->setName('Circle');
    }

    /**
     * @return Point
     */
    public function getCenter(): Point
    {
        return $this->center_;
    }

    /**
     * @param float $center_
     */
    public function setCenter(float $center_): void
    {
        $this->center_ = $center_;
    }

    /**
     * @return float
     */
    public function getRadius(): float
    {
        return $this->radius_;
    }

    /**
     * @param float $radius_
     */
    public function setRadius(float $radius_): void
    {
        $this->radius_ = $radius_;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name_;
    }

    /**
     * @param string $name_
     */
    public function setName(string $name_): void
    {
        $this->name_ = $name_;
    }

    /**
     * @param Point $point
     * @return bool
     */
    public function belong(Point $point): bool
    {
        return (pow($point->getX() - $this->center_->getX(), 2) +
                pow($point->getY() - $this->center_->getY(), 2)) == pow($this->radius_, 2);
    }

    /**
     * @return float
     */
    public function getArea(): float
    {
        return pi() * $this->radius_ * $this->radius_;
    }

    /**
     * @return float
     */
    public function getPerimeter(): float
    {
        return 2 * pi() * $this->radius_;
    }

    /**
     * To simplify the task we put that our circle lies in the point (0;0)
     * and add to result it's real coordinates only at ending
     * @param float $a_
     * @param float $b_
     * @param float $c_
     * @return array
     */
    public function intersectLine(float $a_, float $b_, float $c_): array
    {
        /**
         * @var array Array of Points
         */
        $result = array();

        /**
         * X coordinate of the circle's center
         * @var float
         */
        $p = $this->center_->getX();
        /**
         * Y coordinate of the circle's center
         * @var float
         */
        $q = $this->center_->getY();
        /**
         * Radius of the circle
         * @var float
         */
        $r = $this->radius_;
//        $d = abs($a_ * $p + $b_ * $q + $c_) / sqrt($a_ * $a_ + $b_ * $b_);
//        if ($d <= $r) {
//            $x1 = 0;
//            $y1 = 0;
//            $x2 = 0;
//            $y2 = 0;
//            if ($b_ == 0) {
//                $y1 = $q + sqrt(($r - $c_ / $a_ - $p) * ($r + $c_ / $a_ + $p));
//                $x1 = (-1) * $c_ / $a_;
//                $y2 = $q - sqrt(($r - $c_ / $a_ - $p) * ($r + $c_ / $a_ + $p));
//                $x2 = (-1) * $c_ / $a_;
//            } else {
//                $k = $b_ * $b_ * $p - $a_ * ($b_ * $q + $c_);
//                $s = $a_ * $a_ + $b_ * $b_;
//                $t = $b_ * sqrt($r * $r * $s - pow($a_ * $p + $b_ * $q + $c_, 2));
//                $x1 = ($k + $t) / $s;
//                $y1 = (-1) * ($a_ * $x1 + $c_) / $b_;
//                $x2 = ($k - $t) / $s;
//                $y2 = (-1) * ($a_ * $x2 + $c_) / $b_;
//            }
//            if ($d == $r) {
//                $point = new Point($x1, $y1);
//                if ($this->belong($point)) {
//                    array_push($result, $point);
//                }
//            } else if ($d < $r) {
//                $p1 = new Point($x1, $y1);
//                $p2 = new POint($x2, $y2);
//                if ($this->belong($p1)) {
//                    array_push($result, $p1);
//                }
//                if ($this->belong($p2)) {
//                    array_push($result, $p2);
//                }
//            }
//        }
//        return $result;
        /**
         * Coordinates of nearest point to circle center
         * @var float
         * @var float
         */
        $x0 = -$a_ * $c_ / ($a_ * $a_ + $b_ * $b_);
        $y0 = -$b_ * $c_ / ($a_ * $a_ + $b_ * $b_);

        if (abs($c_ * $c_ - $r * $r * ($a_ * $a_ + $b_ * $b_)) == 0) {
            $p0 = new Point($x0 + $p, $y0 + $q);
            array_push($result, $p0);
        } elseif ($c_ * $c_ < $r * $r * ($a_ * $a_ + $b_ * $b_)) {
            $d = $r * $r - $c_ * $c_ / ($a_ * $a_ + $b_ * $b_);
            $mult = sqrt($d / ($a_ * $a_ + $b_ * $b_));
            $p1 = new Point($x0 + $b_ * $mult + $p, $y0 - $a_ * $mult + $q);
            $p2 = new Point($x0 - $b_ * $mult + $p, $y0 + $a_ * $mult + $q);
            array_push($result, $p1);
            array_push($result, $p2);
        }
        return $result;
    }

    /**
     * @param Rectangle $rect
     * @return array
     */
    public function intersectRect(Rectangle $rect): array
    {
        return $rect->intersect($this);
    }

    /**
     * @param Circle $circle
     * @return array
     */
    public function intersectCircle(Circle $circle): array
    {
        /**
         * @var array Array of Points
         */
        $result = array();

        /**
         * Coordinates x and y and radius of $this circle
         * @var float
         * @var float
         * @var float
         */
        $cx1 = $this->center_->getX();
        $cy1 = $this->center_->getY();
        $r1 = $this->radius_;

        /**
         * Shifted to the center coordinates x and y and radius of other circle
         * @var float
         * @var float
         * @var float
         */
        $cx2 = $circle->getCenter()->getX() - $cx1;
        $cy2 = $circle->getCenter()->getY() - $cy1;
        $r2 = $circle->getRadius();

        if (($cx2 == 0) and ($cy2 == 0)) {
            if ($r1 == $r2) {
                $p0 = new Point($cx1 + $r1, $cy1);
                $p1 = new Point($cx1 - $r1, $cy1);
                $p2 = new Point($cx1, $cy1 + $r1);
                array_push($result, $p0);
                array_push($result, $p1);
                array_push($result, $p2);
            }
        } else {
            $result = $this->intersectLine(-2 * $cx2,
                -2 * $cy2,
                $cx2 * $cx2 + $cy2 * $cy2 - $r2 * $r2 + $r1 * $r1
            );
        }
        return $result;
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
                $p = $this->getCenter()->getX();
                $q = $this->getCenter()->getY();
                $shape->setPa(new Point($shape->getPa()->getX() - $p, $shape->getPa()->getY() - $q));
                $shape->setPb(new Point($shape->getPb()->getX() - $p, $shape->getPb()->getY() - $q));
                $param = $shape->getParameters();
                $result = $this->intersectLine($param[0], $param[1], $param[2]);
                $shape->setPa(new Point($shape->getPa()->getX() + $p, $shape->getPa()->getY() + $q));
                $shape->setPb(new Point($shape->getPb()->getX() + $p, $shape->getPb()->getY() + $q));
                for ($i = 0; $i < count($result); ++$i) {
                    if (!$shape->belong($result[$i])) {
                        array_splice($result, $i, 1);
                    }
                }
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