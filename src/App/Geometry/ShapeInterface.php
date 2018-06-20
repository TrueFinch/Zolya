<?php

namespace App\Geometry;


interface ShapeInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return float
     */
    public function getArea(): float;

    /**
     * @return float
     */
    public function getPerimeter(): float;

    /**
     * @param $shape
     * @return array
     */
    public function intersect(ShapeInterface $shape): array;

    /**
     * @param Point $point
     * @return bool
     */
    public function belong(Point $point): bool;
}
