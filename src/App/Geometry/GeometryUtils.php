<?php
/**
 * Created by PhpStorm.
 * User: truefinch
 * Date: 19.06.18
 * Time: 14:57
 */

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