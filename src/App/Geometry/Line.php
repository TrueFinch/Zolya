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
     * @var Point
     */
    private $a_, $b_;

    /**
     * @var string
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
        return $this->a_->distance($this->b_);
    }
}