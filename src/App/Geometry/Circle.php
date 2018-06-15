<?php
/**
 * Created by PhpStorm.
 * User: truefinch
 * Date: 09.06.18
 * Time: 0:51
 */

namespace App\Geometry;


class Circle
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

}