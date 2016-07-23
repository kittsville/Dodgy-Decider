<?php

use Kittsville\DodgyDecider\Decider;

class ChooseNumberTest extends PHPUnit_Framework_TestCase
{
    public function testSeed()
    {
        $seed     = '7704eb6eae8afb62bdcbd26ff1f1437e';
        $decider1 = new Decider($seed);
        $decider2 = new Decider($seed);
        
        $this->assertEquals(
            $decider1->chooseNumber(0, 1000),
            $decider2->chooseNumber(0, 1000),
            'Given same seed Deciders should choose the same number'
        );
        
        $decider3 = new Decider('24743eeab5f095a696fc1017fb2633b6');
        
        $this->assertNotEquals(
            $decider1->chooseNumber(0, 1000),
            $decider3->chooseNumber(0, 1000),
            'Given different seed Deciders should (probably) choose different numbers'
        );
    }
    
    public function testSalt()
    {
        $seed     = '7704eb6eae8afb62bdcbd26ff1f1437e';
        $decider1 = new Decider($seed);
        $decider2 = new Decider($seed);
        
        $this->assertEquals(
            $decider1->chooseNumber(0, 1000, 'same salt'),
            $decider2->chooseNumber(0, 1000, 'same salt'),
            'Given same seed and salt Deciders should choose the same numbers'
        );
        
        $this->assertNotEquals(
            $decider1->chooseNumber(0, 1000, 'not the'),
            $decider2->chooseNumber(0, 1000, 'same salt'),
            'Given the same seed but a different salt Deciders should (probably) choose different numbers'
        );
    }
    
    public function testParameterOrders()
    {
        $decider = new Decider('7704eb6eae8afb62bdcbd26ff1f1437e');
        
        $this->assertEquals(
            $decider->chooseNumber(0, 1000),
            $decider->chooseNumber(1000),
            "Calling 'chooseNumber' without a \$lower bound should default it to 0"
        );
        
        $this->assertEquals(
            $decider->chooseNumber(0, 1000, 'salty'),
            $decider->chooseNumber(1000, 'salty'),
            "Calling 'chooseNumber' without a \$lower bound but with a salt should default it to 0"
        );
    }
}
