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

}