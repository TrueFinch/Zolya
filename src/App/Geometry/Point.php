<?php

namespace App\Geometry;

class Point
{
    /**
     * @var float
     */
    private $x_;

    /**
     * @var float
     */
    private $y_;

    /**
     * Point constructor.
     * @param float $x
     * @param float $y
     */
    public function __construct(float $x, float $y)
    {
        $this->x_ = $x;
        $this->y_ = $y;
    }

    /**
     * @return float
     */
    public function getX(): float
    {
        return $this->x_;
    }

    /**
     * @param float $x
     */
    public function setX(float $x): void
    {
        $this->x_ = $x;
    }

    /**
     * @return float
     */
    public function getY(): float
    {
        return $this->y_;
    }

    /**
     * @param float $y
     */
    public function setY(float $y): void
    {
        $this->y_ = $y;
    }

    /**
     * @param Point $other
     * @return float
     */
    public function distance(Point $other): float
    {
        return sqrt(
            pow($this->x_ - $other->getX(), 2) + pow($this->y_ - $other->getY(), 2)
        );
    }
}
