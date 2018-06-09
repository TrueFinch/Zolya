<?php
/**
 * Created by PhpStorm.
 * User: truefinch
 * Date: 07.06.18
 * Time: 22:32
 */

namespace App\Geometry;

include 'ShapeInterface.php';

class Line implements ShapeInterface
{
    /**
     * @var Point boundaries of a segment
     */
    private $pa_, $pb_;

    /**
     * @var double parameters of line equation
     */
    private $a_, $b_, $c_;

    /**
     * @var string $name_ name of class? idk
     */
    private $name_;

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
     * @return Point
     */
    public function getPb(): Point
    {
        return $this->pb_;
    }

    public function getParameters(): array
    {
        return array($this->a_, $this->b_, $this->c_);
    }

    /**
     * @param Line $line
     * @return array
     */
    private function intersectLine(Line $line): array
    {
        /**
         * @var array of Points
         */
        $result = array();
        /**
         * @var array of double
         */
        $p = $this->getParameters();
        /**
         * @var double parameters of $this line
         */
        $a1 = $p[0];
        $b1 = $p[1];
        $c1 = $p[2];
        /**
         * @var array of double
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
     * @param $shape
     * @return array
     */
    public function intersect($shape): array
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
                break;
            case "Circle":
                break;
        }
        return $result;
    }

    public function belong(Point $point): bool
    {
        /**
         * @var array of double
         */
        $p = $this->getParameters();
        /**
         * @var double parameters of $this line
         */
        $a1 = $p[0];
        $b1 = $p[1];
        $c1 = $p[2];
        // TODO: Implement belong() method.
    }

}