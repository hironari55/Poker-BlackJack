<?php

use PHPUnit\Framework\TestCase;
use VendingMachine\Snack;

require_once(__DIR__ . '/../../lib/oop_vendingMachine/Snack.php');

class SnackTest extends TestCase
{
    public function testGetPrice()
    {
        $potatoChips = new Snack('potato chips');
        $this->assertSame(150, $potatoChips->getPrice());
    }

    public function testGetUseCup()
    {
        $potatoChips = new Snack('potato chips');
        $this->assertSame(0, $potatoChips->getUseCup());
    }
}
