<?php

use Kittsville\DodgyDecider\Decider;

class ChooseElementTest extends PHPUnit_Framework_TestCase
{
    private $seed;
    private $array;
    
    protected function setUp()
    {
        $this->seed  = '7704eb6eae8afb62bdcbd26ff1f1437e';
        $this->array = range(0, 10000);
    }
    
    public function testSeed()
    {
        $decider1 = new Decider($this->seed);
        $decider2 = new Decider($this->seed);
        
        $this->assertEquals(
            $decider1->chooseElement($this->array),
            $decider2->chooseElement($this->array),
            'Given same seed Deciders should choose the same element'
        );
        
        $decider3 = new Decider('24743eeab5f095a696fc1017fb2633b6');
        
        $this->assertNotEquals(
            $decider1->chooseElement($this->array),
            $decider3->chooseElement($this->array),
            'Given a different seed Deciders should (probably) choose different elements'
        );
    }
    
    public function testSalt()
    {
        $decider1 = new Decider($this->seed);
        $decider2 = new Decider($this->seed);
        
        $this->assertEquals(
            $decider1->chooseElement($this->array, 'same salt'),
            $decider2->chooseElement($this->array, 'same salt'),
            'Given same seed and salt Deciders should choose the same element'
        );
        
        $this->assertNotEquals(
            $decider1->chooseElement($this->array, 'not the'),
            $decider2->chooseElement($this->array, 'same salt'),
            'Given the same seed but a different salt Deciders should (probably) choose different elements'
        );
    }
}
