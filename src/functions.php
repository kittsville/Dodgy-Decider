<?php
namespace Kittsville\DodgyDecider;

if (!function_exists('Kittsville\DodgyDecider\greatestCommonFactor')) {
    /**
     * Calculates largest integer that divides into the given integers
     * e.g. $a = 5, $b = 10, $gcf = 5
     * @see http://wpscholar.com/blog/euclidean-algorithm-php/
     *
     * @param  int $a Number to find gcf of
     * @param  int $b Number to find gcf of
     * @return int    Greatest common factor of given two numbers
     */
    function greatestCommonFactor($a, $b)
    {
        $large     = $a > $b ? $a : $b;
        $small     = $a > $b ? $b : $a;
        $remainder = $large % $small;
        
        if (0 === $remainder) {
            return $small;
        } else {
            return greatestCommonFactor($small, $remainder);
        }
    }

    /**
     * Smallest number that can divide into both given numbers
     * e.g. $a = 5, $b = 10, $lcm = 10
     *
     * @param  int $a Number to find lcm of
     * @param  int $b Number to find lcm of
     * @return int    Lowest common multiple of given two numbers
     */
    function lowestCommonMultiple($a, $b)
    {
        return ($a / greatestCommonFactor($a, $b)) * $b;
    }
}
