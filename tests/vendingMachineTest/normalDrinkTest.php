<?php

use PHPUnit\Framework\TestCase;
use VendingMachine\NormalDrink;

require_once(__DIR__ . '/../../lib/oop_vendingMachine/normalDrink.php');

class NormalDrinkTest extends TestCase
{
    public function testGetPrice()
    {
        $cider = new NormalDrink('cider');
        $this->assertSame(100, $cider->getPrice());
    }

    public function testGetUseCup()
    {
        $cider = new NormalDrink('cider');
        $this->assertSame(0, $cider->getUseCup());
    }
}
