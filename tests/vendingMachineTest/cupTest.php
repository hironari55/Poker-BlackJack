<?php

use PHPUnit\Framework\TestCase;
use VendingMachine\Cup;

//require_once(__DIR__ . '/../../lib/oop_vendingMachine/cup.php');

class CupTest extends TestCase
{
    public function testGetPrice()
    {
        $iceCoffee = new Cup('ice cup coffee');
        $this->assertSame(100, $iceCoffee->getPrice());
    }

    public function testGetUseCup()
    {
        $iceCoffee = new Cup('ice cup coffee');
        $this->assertSame(1, $iceCoffee->getUseCup());
    }
}
