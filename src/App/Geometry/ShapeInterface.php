<?php

namespace App\Geometry;
/**
 * 
 * @param float $a
 * @param float $b
 * @param float $c
 * @param float $d
 * @return float
 */
function det(float $a, float $b, float $c, float $d): float
{
    return $a * $d - $b * $c;
}

interface ShapeInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;

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
    public function intersect($shape): array;

    /**
     * @param Point $point
     * @return bool
     */
    public function belong(Point $point): bool;
}
