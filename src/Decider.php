<?php
namespace Kittsville\DodgyDecider;

use Kittsville\DodgyDecider\greatestCommonFactor;
use \LogicException;

class Decider {
    protected $seed = 'ffffffffffffffffffffffffffffffff';
    
    /**
     * Sets seed for making decisions
     * @param  string $seed Hexadecimal seed
     * @return void
     */
    public function seed($seed)
    {
        $this->seed = $seed;
    }
    
    /**
     * Calculates how many digits of hex would be needed to make a number
     * bigger than the one given
     */
    public function hexDigitsNeeded($number)
    {
        $digits_needed = 1;
        $hex_value = 16;
        
        while ($hex_value < $number) {
            $digits_needed++;
            $hex_value = $hex_value * 16;
        }
        
        return $digits_needed;
    }
    
    /**
     * Chooses number between given range or between 0 and given number
     *
     * @throws LogicException If given numeric range is invalid
     *
     * @param  int    $lower OPTIONAL Lower bound
     * @param  int    $upper Upper bound
     * @param  string $salt  OPTIONAL Salt to personalise choice
     *
     * @return int Chosen number between range
     */
    public function chooseNumber($a, $b = null, $c = null)
    {
        if ($b === null && $c === null) {
            // If only $upper has been given
            $lower = 0;
            $upper = $a;
            $salt  = null;
        } else if ($c === null) {
            // If the $upper and $lower are given
            $lower = $a;
            $upper = $b;
            $salt  = null;
        } else {
            // If all three parameters are given
            $lower = $a;
            $upper = $b;
            $salt  = $c;
        }
        
        $num_choices = ($upper - $lower) + 1;
        
        if ($num_choices <= 0) {
            throw LogicException('Upper bound must be greater than or equal to lower bound');
        }
        
        if ($salt !== null) {
            $salted_seed = hash('sha256', $this->seed . $salt);
        } else {
            $salted_seed = $this->seed;
        }
        
        // Uses 2 orders of magnitude to avoid clustering
        $hex_needed = $this->hexDigitsNeeded($num_choices) + 2;
        
        $seed_possibilities = pow(16, $hex_needed);
        
        // Calculates what to multiply the seed by so it shares a factor with the number of possible values
        $seed_multiplier = $num_choices / greatestCommonFactor($num_choices, $seed_possibilities);
        
        // Calculates what to divide multiplied seed by to get chosen element
        $factor_divisor = ($seed_multiplier * $seed_possibilities) / $num_choices;
        
        $hex_seed = hexdec(substr($salted_seed, 0, $hex_needed));
        
        $choice = intval(($hex_seed * $seed_multiplier) / $factor_divisor);
        
        return $lower + $choice;
    }
    
    /**
     * Chooses a value from an array
     *
     * @throws LogicException If array has no elements
     *
     * @param  Array  $array Array of choices to choose an element from
     * @param  string $salt  OPTIONAL Salt to personalise choice
     *
     * @return mixed Chosen array value
     */
    public function chooseElement(Array $array, $salt = null)
    {
        $choices     = array_keys($array);
        $num_choices = count($choices);
        
        if ($num_choices === 0) {
            throw LogicException('Array has no elements to choose one from');
        }
        
        $choice = $this->chooseNumber(0, $num_choices - 1, $salt);
        
        return $array[$choices[$choice]];
    }
}