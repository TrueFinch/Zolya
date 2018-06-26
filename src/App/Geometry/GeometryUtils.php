<?php
/**
 * Created by PhpStorm.
 * User: truefinch
 * Date: 27.06.18
 * Time: 3:35
 */

namespace App\Geometry;

class GeometryUtils
{
    /**
     *Determinant of the square matrix 2x2
     * @param float $a
     * @param float $b
     * @param float $c
     * @param float $d
     * @return float
     */
    public function det(float $a, float $b, float $c, float $d): float
    {
        return $a * $d - $b * $c;
    }
}